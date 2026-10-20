<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Courier;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Order::whereNotIn('status', ['return', 'completed', 'cancelled'])->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('invoice_no', fn ($row) => $row->order_number)
                ->addColumn('customer_name', fn ($row) => $row->full_name)
                ->addColumn('order_date', fn ($row) => $row->created_at->format('d M, Y'))
                ->addColumn('total_amount', fn ($row) => number_format($row->total, 2).' ৳')
                ->addColumn('payment_status', function ($row) {
                    $class = match (strtolower($row->payment_status)) {
                        'paid' => 'success',
                        'due', 'pending' => 'warning',
                        default => 'secondary',
                    };

                    return '<span class="badge bg-'.$class.'">'.ucfirst($row->payment_status).'</span>';
                })
                ->addColumn('status', function ($row) {
                    $colors = [
                        'pending' => '#f59e0b',
                        'accepted' => '#3b82f6',
                        'on-the-way' => '#6366f1',
                        'return' => '#6b7280',
                        'completed' => '#10b981',
                        'cancelled' => '#ef4444',
                    ];

                    $status = $row->status ?? 'pending';
                    $color = $colors[$status] ?? '#6b7280';

                    return '
                        <button class="btn-order-status btn-status-change"
                            data-id="'.$row->id.'"
                            style="
                                background: '.$color.'15;
                                color: '.$color.';
                                border: 1px solid '.$color.';
                                padding: 4px 10px;
                                border-radius: 6px;
                                font-size: 12px;
                                font-weight: 500;
                            ">
                            '.ucfirst(str_replace('-', ' ', $status)).'
                        </button>
                    ';
                })
                ->addColumn('action', function ($row) {
                    $showBtn = '<button class="btn btn-icon btn-soft-info btn-show"
                                    data-id="'.$row->id.'" title="View Order">
                                    <i class="fa-regular fa-eye"></i>
                                </button>';

                    $editBtn = '<a href="'.route('orders.edit', $row->id).'"
                                    class="btn btn-icon btn-soft-primary" title="Edit Order">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>';

                    $invoiceBtn = '<a href="'.route('orders.invoice', $row->id).'"
                                        target="_blank" class="btn btn-icon btn-soft-success" title="Invoice">
                                        <i class="fa-regular fa-file-lines"></i>
                                    </a>';

                    $deleteForm = '
                        <form class="delete-form d-inline" action="'.route('orders.destroy', $row->id).'" method="POST">
                            '.csrf_field().method_field('DELETE').'
                            <button type="button" class="btn btn-icon btn-soft-danger btn-delete" title="Delete Order">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </form>
                    ';

                    return '<div class="d-flex align-items-center justify-content-center gap-2">
                                '.$showBtn.' '.$editBtn.' '.$invoiceBtn.' '.$deleteForm.'
                            </div>';
                })
                ->rawColumns(['payment_status', 'status', 'action'])
                ->make(true);
        }

        return view('backend.order.index');
    }

    public function ecommerceSales(Request $request)
    {
        if ($request->ajax()) {
            $data = Order::where('status', 'completed')->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('invoice_no', fn ($row) => $row->order_number)
                ->addColumn('customer_name', fn ($row) => $row->full_name)
                ->addColumn('order_date', fn ($row) => $row->created_at->format('d M, Y'))
                ->addColumn('total_amount', fn ($row) => number_format($row->total, 2).' ৳')
                ->addColumn('payment_status', function ($row) {
                    $class = match (strtolower($row->payment_status)) {
                        'paid' => 'success',
                        'due', 'pending' => 'warning',
                        default => 'secondary',
                    };

                    return '<span class="badge bg-'.$class.'">'.ucfirst($row->payment_status).'</span>';
                })
                ->addColumn('status', function ($row) {
                    return '<span class="badge bg-success">Completed</span>';
                })
                ->addColumn('action', function ($row) {
                    $showBtn = '<button class="btn btn-icon btn-soft-info btn-show" data-id="'.$row->id.'" title="View Order"><i class="fa-regular fa-eye"></i></button>';
                    $invoiceBtn = '<a href="'.route('orders.invoice', $row->id).'" target="_blank" class="btn btn-icon btn-soft-success" title="Invoice"><i class="fa-regular fa-file-lines"></i></a>';

                    return '<div class="d-flex align-items-center justify-content-center gap-2">'.$showBtn.' '.$invoiceBtn.'</div>';
                })
                ->rawColumns(['payment_status', 'status', 'action'])
                ->make(true);
        }

        return view('backend.order.complete_orders');
    }

    public function checkNewOrder()
    {
        $lastOrderId = Order::max('id');

        return response()->json([
            'last_order_id' => $lastOrderId,
        ]);
    }

    public function statusModal($id)
    {
        $order = Order::findOrFail($id);

        $statuses = [
            'pending' => 'Pending',
            'accepted' => 'Accepted',
            'on-the-way' => 'On The Way',
            'return' => 'Return',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ];

        return view('backend.order.partials.status_modal', compact('order', 'statuses'));
    }

    public function statusUpdate(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,on-the-way,return,completed,cancelled',
            'return_charge' => 'nullable|numeric|min:0|max:99999999',
        ]);
        DB::beginTransaction();

        try {
            $order = Order::with('items')->lockForUpdate()->findOrFail($id);
            $oldStatus = $order->status;
            $newStatus = $request->status;

            $order->status = $newStatus;

            if ($request->has('return_charge')) {
                $order->return_charge = $request->return_charge;
            }

            if ($newStatus === 'completed') {
                $order->payment_status = 'paid';
            }

            if (in_array($newStatus, ['return', 'cancelled']) && ! in_array($oldStatus, ['return', 'cancelled'])) {
                foreach ($order->items as $item) {
                    $this->updateStockQuantity($item, 'increment');
                }
            } elseif (! in_array($newStatus, ['return', 'cancelled']) && in_array($oldStatus, ['return', 'cancelled'])) {
                foreach ($order->items as $item) {
                    $this->updateStockQuantity($item, 'decrement');
                }
            }

            $order->save();
            DB::commit();

            // Automated Status Change SMS
            if (setting('status_sms_enabled', '1') == '1' && !empty($order->phone) && $oldStatus !== $newStatus) {
                try {
                    $storeName = setting('company_name') ?: 'Unibox';
                    $statusMsg = match($newStatus) {
                        'accepted' => "Dear {$order->full_name}, your order #{$order->order_number} has been ACCEPTED and is being prepared.",
                        'on-the-way' => "Dear {$order->full_name}, your order #{$order->order_number} is ON THE WAY for delivery" . ($order->tracking_number ? " (Tracking: {$order->tracking_number})" : "") . ".",
                        'completed' => "Dear {$order->full_name}, your order #{$order->order_number} has been DELIVERED. Thank you for shopping with {$storeName}!",
                        'cancelled' => "Dear {$order->full_name}, your order #{$order->order_number} has been CANCELLED.",
                        default => null
                    };
                    if ($statusMsg) {
                        \App\Services\SmsService::send($order->phone, $statusMsg);
                    }
                } catch (\Throwable $t) {
                    \Illuminate\Support\Facades\Log::error('Order status SMS error: ' . $t->getMessage());
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully',
            ]);

        } catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);

            return response()->json(['errors' => ['Unable to update order status.']], 500);
        }
    }

    private function updateStockQuantity($item, $action = 'increment')
    {
        $mainProduct = Product::whereKey($item->product_id)->lockForUpdate()->first();
        if (! $mainProduct) {
            return;
        }

        $qty = (int) $item->quantity;

        if ($action === 'increment') {
            $mainProduct->increment('stock', $qty);
        } else {
            if ($mainProduct->stock < $qty) {
                throw ValidationException::withMessages(['stock' => 'Insufficient stock to reactivate this order.']);
            }
            $mainProduct->decrement('stock', $qty);
        }

        if ($mainProduct->product_type === 'multiple') {

            $colorId = is_numeric($item->color_id) ? $item->color_id : ($item->color ? Color::where('name', $item->color)->value('id') : null);
            $sizeId = is_numeric($item->size_id) ? $item->size_id : ($item->size ? Size::where('name', $item->size)->value('id') : null);

            $query = ProductVariant::where('product_id', $item->product_id)
                ->where('color_id', $colorId ?: null)
                ->where('size_id', $sizeId ?: null);

            $variant = $query->lockForUpdate()->first();
            if (! $variant || ($action !== 'increment' && $variant->stock < $qty)) {
                throw ValidationException::withMessages(['stock' => 'The order variation is unavailable or has insufficient stock.']);
            }

            if ($action === 'increment') {
                $variant->increment('stock', $qty);
            } else {
                $variant->decrement('stock', $qty);
            }
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function getPendingCount()
    {
        $count = Order::where('status', 'pending')->count();

        return response()->json(['count' => $count]);
    }

    public function invoice($id)
    {
        $order = Order::with('items')->findOrFail($id);

        return view('backend.order.partials.invoice', compact('order'));
    }

    public function show($id)
    {
        $order = Order::with(['items.product', 'items.color', 'items.size', 'courier'])->findOrFail($id);

        return view('backend.order.show', compact('order'));
    }

    public function sendToSteadfast($id)
    {
        $order = Order::findOrFail($id);

        $steadfastService = new \App\Services\SteadfastService();
        $result = $steadfastService->createOrder($order);

        if ($result['success']) {
            $courier = \App\Models\Courier::firstOrCreate(
                ['name' => 'Steadfast'],
                ['is_active' => true]
            );

            $order->courier_id = $courier->id;
            $order->tracking_number = $result['tracking_code'];
            $order->status = 'on-the-way';
            $order->save();

            // Trigger SMS if enabled
            if (setting('status_sms_enabled', '1') == '1' && !empty($order->phone)) {
                try {
                    $storeName = setting('company_name') ?: 'Unibox';
                    $msg = "Dear {$order->full_name}, your order #{$order->order_number} has been dispatched via Steadfast Courier (Tracking: {$order->tracking_number}). Thank you for shopping with {$storeName}!";
                    \App\Services\SmsService::send($order->phone, $msg);
                } catch (\Throwable $t) {
                    \Illuminate\Support\Facades\Log::error('Courier dispatch SMS error: ' . $t->getMessage());
                }
            }

            return back()->with('success', $result['message'] . " (Tracking Code: {$result['tracking_code']})");
        }

        return back()->with('error', $result['message']);
    }

    public function sendToPathao($id)
    {
        $order = Order::findOrFail($id);

        $pathaoService = new \App\Services\PathaoService();
        $result = $pathaoService->createOrder($order);

        if ($result['success']) {
            $courier = \App\Models\Courier::firstOrCreate(
                ['name' => 'Pathao'],
                ['is_active' => true]
            );

            $order->courier_id = $courier->id;
            $order->tracking_number = $result['tracking_code'];
            $order->status = 'on-the-way';
            $order->save();

            // Trigger SMS if enabled
            if (setting('status_sms_enabled', '1') == '1' && !empty($order->phone)) {
                try {
                    $storeName = setting('company_name') ?: 'Unibox';
                    $msg = "Dear {$order->full_name}, your order #{$order->order_number} has been dispatched via Pathao Courier (Consignment: {$order->tracking_number}). Thank you for shopping with {$storeName}!";
                    \App\Services\SmsService::send($order->phone, $msg);
                } catch (\Throwable $t) {
                    \Illuminate\Support\Facades\Log::error('Pathao dispatch SMS error: ' . $t->getMessage());
                }
            }

            return back()->with('success', $result['message']);
        }

        return back()->with('error', $result['message']);
    }

    public function edit($id)
    {
        $order = Order::with('items')->findOrFail($id);
        $couriers = Courier::where('is_active', true)->get();

        return view('backend.order.edit', compact('order', 'couriers'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string|max:1000',
            'shipping' => 'required|numeric|min:0|max:99999999',
            'payment_status' => 'required|in:paid,unpaid,pending,due',
            'status' => 'required|in:pending,accepted,on-the-way,return,completed,cancelled',
            'courier_id' => 'nullable|integer|exists:couriers,id',
            'tracking_number' => 'nullable|string|max:255',
            'return_charge' => 'nullable|numeric|min:0|max:99999999',
            'items' => 'nullable|array',
            'items.*.quantity' => 'required|integer|min:1|max:10000',
            'items.*.price' => 'required|numeric|min:0|max:99999999',
        ]);
        DB::transaction(function () use ($data, $id) {
            $order = Order::with('items')->lockForUpdate()->findOrFail($id);
            $oldReserved = ! in_array($order->status, ['return', 'cancelled']);
            $newReserved = ! in_array($data['status'], ['return', 'cancelled']);
            foreach ($order->items as $item) {
                $new = $data['items'][$item->id] ?? ['quantity' => $item->quantity, 'price' => $item->price];
                $difference = ($newReserved ? (int) $new['quantity'] : 0) - ($oldReserved ? $item->quantity : 0);
                if ($difference !== 0) {
                    $adjustment = clone $item;
                    $adjustment->quantity = abs($difference);
                    $this->updateStockQuantity($adjustment, $difference > 0 ? 'decrement' : 'increment');
                }
                $item->update(['quantity' => $new['quantity'], 'price' => $new['price'], 'total' => round($new['quantity'] * $new['price'], 2)]);
            }
            $subtotal = $order->items()->sum('total');
            $order->update([
                'full_name' => $data['customer_name'], 'phone' => $data['customer_phone'],
                'address' => $data['customer_address'], 'shipping' => $data['shipping'],
                'payment_status' => $data['payment_status'], 'status' => $data['status'],
                'courier_id' => $data['courier_id'] ?? null,
                'tracking_number' => $data['tracking_number'] ?? null,
                'return_charge' => $data['return_charge'] ?? 0,
                'subtotal' => $subtotal, 'total' => round($subtotal + $data['shipping'], 2),
            ]);
        }, 3);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully');
    }

    public function destroy(Request $request, $id)
    {
        $order = Order::find($id);

        if (! $order) {
            return response()->json([
                'message' => 'Order not found.',
            ], 404);
        }

        try {
            DB::beginTransaction();
            if (! in_array($order->status, ['return', 'cancelled'])) {
                foreach ($order->items as $item) {
                    $this->updateStockQuantity($item, 'increment');
                }
            }

            $order->items()->delete();
            $order->delete();
            DB::commit();

            return response()->json([
                'message' => 'Order deleted successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to delete order. '.$e->getMessage(),
            ], 500);
        }
    }
}

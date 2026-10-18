<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'value' => 'float',
        'min_order_amount' => 'float',
        'max_discount' => 'float',
        'start_date' => 'date',
        'end_date' => 'date',
        'status' => 'boolean',
    ];

    /**
     * Check if coupon is currently valid for a given subtotal
     */
    public function isValidForAmount(float $subtotal): array
    {
        if (!$this->status) {
            return ['valid' => false, 'message' => 'This coupon is inactive.'];
        }

        $today = now()->startOfDay();
        if ($this->start_date && $today->lt($this->start_date)) {
            return ['valid' => false, 'message' => 'Coupon is not yet active.'];
        }

        if ($this->end_date && $today->gt($this->end_date)) {
            return ['valid' => false, 'message' => 'Coupon has expired.'];
        }

        if ($this->usage_limit !== null && $this->used_count >= $this->usage_limit) {
            return ['valid' => false, 'message' => 'Coupon usage limit has been reached.'];
        }

        if ($this->min_order_amount > 0 && $subtotal < $this->min_order_amount) {
            return ['valid' => false, 'message' => 'Minimum order amount for this coupon is ৳' . number_format($this->min_order_amount, 2)];
        }

        return ['valid' => true, 'message' => 'Coupon is valid.'];
    }

    /**
     * Calculate discount amount
     */
    public function calculateDiscount(float $subtotal): float
    {
        if ($this->type === 'percent') {
            $discount = ($subtotal * $this->value) / 100;
            if ($this->max_discount !== null && $this->max_discount > 0) {
                $discount = min($discount, $this->max_discount);
            }
        } else {
            $discount = min($this->value, $subtotal);
        }

        return round($discount, 2);
    }
}


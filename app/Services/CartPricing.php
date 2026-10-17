<?php

namespace App\Services;

use App\Models\AttributeOption;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Validation\ValidationException;

class CartPricing
{
    public function quote(Product $product, array $item, bool $lock = false): array
    {
        if (! $product->status || $product->deleted_at) {
            throw ValidationException::withMessages(['cart' => 'This product is no longer available.']);
        }
        $variant = null;
        $price = (float) $product->final_price;
        if ($product->product_type === 'multiple') {
            $query = ProductVariant::where('product_id', $product->id)
                ->where('color_id', ($item['color_id'] ?? null) ?: null)
                ->where('size_id', ($item['size_id'] ?? null) ?: null);
            $variant = ($lock ? $query->lockForUpdate() : $query)->first();
            if (! $variant) {
                throw ValidationException::withMessages(['cart' => 'Select an available size and color.']);
            }
            $price = $variant->selling_price > 0 ? (float) $variant->selling_price : $price;
        } elseif (! empty($item['color_id']) || ! empty($item['size_id'])) {
            throw ValidationException::withMessages(['cart' => 'This product has no selectable variation.']);
        }

        $labels = [];
        if ($product->is_calculator) {
            $dimensions = validator($item['dimensions'] ?? [], [
                'w_ft' => 'required|numeric|min:0|max:1000',
                'w_in' => 'required|numeric|min:0|lt:12',
                'h_ft' => 'required|numeric|min:0|max:1000',
                'h_in' => 'required|numeric|min:0|lt:12',
            ])->validate();
            $area = ($dimensions['w_ft'] + $dimensions['w_in'] / 12) * ($dimensions['h_ft'] + $dimensions['h_in'] / 12);
            if ($area <= 0) {
                throw ValidationException::withMessages(['dimensions' => 'Enter positive width and height.']);
            }
            $price = $area * $product->price_per_sqft;
            $labels[] = "Dimension: {$dimensions['w_ft']}ft {$dimensions['w_in']}in x {$dimensions['h_ft']}ft {$dimensions['h_in']}in (".round($area, 4).' sq.ft)';
        }
        $attributes = $item['custom_attributes'] ?? [];
        if (! empty($item['attributes']) && ! array_key_exists('custom_attributes', $item)) {
            throw ValidationException::withMessages(['cart' => 'Please add this item again to confirm its product options.']);
        }
        $allowed = $product->attributes()->pluck('attributes.id')->all();
        foreach ($attributes as $id => $value) {
            if (! in_array($id, $allowed)) {
                throw ValidationException::withMessages(['custom_attributes' => 'Invalid product attribute.']);
            }
            $option = AttributeOption::where('attribute_id', $id)->where('value', $value)->first();
            if (! $option) {
                throw ValidationException::withMessages(['custom_attributes' => 'Invalid product option.']);
            }
            $price += (float) $option->extra_price;
            $labels[] = $value;
        }
        if (! is_finite($price) || $price < 0) {
            throw ValidationException::withMessages(['cart' => 'This product has an invalid price.']);
        }

        return ['price' => round($price, 2), 'attributes' => $labels, 'variant' => $variant];
    }
}

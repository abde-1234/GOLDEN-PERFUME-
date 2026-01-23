<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:120'],
            'customer_phone' => ['required', 'string', 'max:40'],
            'customer_address' => ['required', 'string', 'max:255'],
            'customer_note' => ['nullable', 'string', 'max:1000'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'distinct'],
            'items.*.qty' => ['required', 'integer', 'min:1'],
        ], [], [
            'customer_name' => 'الاسم',
            'customer_phone' => 'الهاتف',
            'customer_address' => 'العنوان',
            'customer_note' => 'الملاحظة',
            'items' => 'المنتجات',
        ]);

        $productIds = collect($validated['items'])->pluck('product_id')->all();
        $products = Product::query()
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        if ($products->isEmpty()) {
            throw ValidationException::withMessages([
                'items' => 'المنتجات المحددة غير صالحة.',
            ]);
        }

        $normalizedItems = [];
        $total = 0;

        foreach ($validated['items'] as $row) {
            $product = $products->get($row['product_id']);
            if (!$product) {
                throw ValidationException::withMessages([
                    'items' => 'أحد المنتجات في السلة غير صالح.',
                ]);
            }

            $qty = $row['qty'];
            $lineTotal = (float) $product->price * $qty;

            $normalizedItems[] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'qty' => $qty,
                'subtotal' => $lineTotal,
            ];

            $total += $lineTotal;
        }

        $promoCode = strtoupper(trim((string) $request->input('promo_code', '')));
        $discount = 0;
        if ($promoCode === 'GP10') {
            $discount = round($total * 0.10, 2);
        } elseif ($promoCode === 'GP5') {
            $discount = round($total * 0.05, 2);
        } elseif ($promoCode === 'WELCOME10') {
            $discount = min($total, 10);
        }
        $grandTotal = max(0, round($total - $discount, 2));

        $minOrder = (float) config('goldenperfume.min_order_total', 0);
        if ($minOrder > 0 && $grandTotal < $minOrder) {
            throw ValidationException::withMessages([
                'items' => "الحد الأدنى للطلب هو {$minOrder}.",
            ]);
        }

        $shippingFee = (float) config('goldenperfume.shipping_fee', 0);
        $freeThreshold = (float) config('goldenperfume.free_shipping_threshold', 0);
        $shipping = ($freeThreshold > 0 && $grandTotal >= $freeThreshold) ? 0 : $shippingFee;
        $finalTotal = max(0, round($grandTotal + $shipping, 2));

        $note = $validated['customer_note'] ?? null;
        if ($promoCode !== '') {
            $promoInfo = "Promo {$promoCode}: -{$discount}";
            $note = $note ? ($note . " | " . $promoInfo) : $promoInfo;
        }
        if ($shipping > 0) {
            $shipInfo = "Shipping: +{$shipping}";
            $note = $note ? ($note . " | " . $shipInfo) : $shipInfo;
        } else {
            $note = $note ? ($note . " | Shipping: FREE") : "Shipping: FREE";
        }

        $order = Order::create([
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'customer_address' => $validated['customer_address'],
            'customer_note' => $note,
            'items' => $normalizedItems,
            'total' => $finalTotal,
            'status' => 'new',
        ]);

        return response()->json([
            'ok' => true,
            'order_id' => $order->id,
        ]);
    }
}

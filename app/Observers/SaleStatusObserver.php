<?php

namespace App\Observers;

use App\Models\Products;
use App\Models\Sale;
use App\Models\SaleDetail;

class SaleStatusObserver
{
    public function updating(Sale $sale)
    {
        if ($sale->isDirty('status_id') && $sale->status_id == 3) {
            $details = SaleDetail::select()
                ->where('sale_id', $sale->id)
                ->where('stock_reduced', false)
                ->get();

            foreach ($details as $detail) {
                $item = Products::find($detail->product_id);
                if (!$item) continue;

                $quantity = (float) $detail->quantity;
                $item->stock -= $quantity;
                $detail->stock_reduced = true;

                $item->save();
                $detail->save();
            }
        }
    }
}


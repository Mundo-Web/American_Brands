<?php

namespace App\Observers;

use App\Models\Products;
use Illuminate\Support\Str;

class ItemSlugObserver
{
    public function created(Products $item)
    {
        $name = $item->producto . '-' . $item->color . '-' . $item->peso;
        Products::where('id', $item->id)->update([
            'slug' => Str::slug($name)
        ]);
    }

    public function updating(Products $item)
    {
        if ($item->isDirty('producto') || $item->isDirty('color') || $item->isDirty('peso')) {
            $name = $item->producto . '-' . $item->color . '-' . $item->peso;
            Products::where('id', $item->id)->update([
                'slug' => Str::slug($name)
            ]);
        }
    }
}

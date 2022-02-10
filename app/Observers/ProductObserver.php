<?php

namespace App\Observers;

use App\Models\product;
use Illuminate\Support\Facades\Storage;

class ProductObserver
{
    /**
     * Handle the product "created" event.
     *
     * @param  \App\Models\product  $product
     * @return void
     */
    public function created(product $product)
    {
        //
    }

    /**
     * Handle the product "updated" event.
     *
     * @param  \App\Models\product  $product
     * @return void
     */
    public function updated(product $product)
    {
        //
    }

    /**
     * Handle the product "deleted" event.
     *
     * @param  \App\Models\product  $product
     * @return void
     */
    public function deleted(product $product)
    {
        //
    }

    /**
     * Handle the product "restored" event.
     *
     * @param  \App\Models\product  $product
     * @return void
     */
    public function restored(product $product)
    {
        //
    }

    public function forceDeleted(product $product)
    {
        if($product->image){
            Storage::disk('public')->delete($product->image);
        }
    }
}

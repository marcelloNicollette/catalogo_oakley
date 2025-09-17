<?php

namespace App\Listeners;

use App\Events\ProductColorsSynced;
use Illuminate\Support\Facades\Log;

class LogProductColorsSynced
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProductColorsSynced $event): void
    {
        Log::info('Cores sincronizadas para o produto ID: ' . $event->product->id);
    }
}

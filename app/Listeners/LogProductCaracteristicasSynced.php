<?php

namespace App\Listeners;

use App\Events\ProductCaracteristicasSynced;
use Illuminate\Support\Facades\Log;

class LogProductCaracteristicasSynced
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
    public function handle(ProductCaracteristicasSynced $event): void
    {
        Log::info('Características sincronizadas para o produto ID: ' . $event->product->id);
    }
}

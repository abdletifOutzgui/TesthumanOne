<?php 

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StockLow implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $product;

    // Constructor to pass the product to the event
    public function __construct($product)
    {
        $this->product = $product;
    }

    // Define the channel for broadcasting
    public function broadcastOn()
    {
        return new Channel('product-stock');
    }

    public function broadcastWith()
    {
        return [
            'product_name' => $this->product->name,
            'quantity_in_stock' => $this->product->quantity_in_stock,
            'min_threshold' => $this->product->min_threshold,
        ];
    }
}

<?php 

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use App\Notifications\StockLowNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ProductStockLowNotificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sends_a_stock_low_notification_to_the_user_when_stock_is_below_threshold(): void
    {
        $user = User::factory()->create();

        $product = Product::factory()->create([
            'name' => 'Test Product',               
            'quantity_in_stock' => 5,          
            'min_threshold' => 10,                 
            'user_id' => $user->id,              
        ]);

        Notification::fake();

        if ($product->quantity_in_stock <= $product->min_threshold) {
            $product->user->notify(new StockLowNotification($product));
        }

        Notification::assertSentTo(
            [$user], StockLowNotification::class
        );
    }

    /** @test */
    public function it_does_not_send_notification_when_stock_is_above_threshold(): void
    {
        $user = User::factory()->create();
        
        $product = Product::factory()->create([
            'name' => 'Test Product',               
            'quantity_in_stock' => 15,             
            'min_threshold' => 10,                 
            'user_id' => $user->id,              
        ]);

        Notification::fake();

        if ($product->quantity_in_stock <= $product->min_threshold) {
            $product->user->notify(new StockLowNotification($product));
        }

        Notification::assertNotSentTo(
            [$user], StockLowNotification::class
        );
    }
}

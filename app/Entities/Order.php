<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'reference',
        'user_id',
        'status',
        'subtotal',
        'comission',
        'total',
        'currency_code',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function createNew($items)
    {

        // Creates a new Order
        $order = new Order();
        $order->reference = str_random(6);
        $order->status = 0;
        $order->subtotal = 0;
        $order->comission = 0;
        $order->fee = 0;
        $order->tax = 0;
        $order->total = 0;
        $order->currency_code = 978;
        $order->created_at = Carbon::now();
        $order->updated_at = Carbon::now();
        $order->save();

        // Adds Items to Order
        foreach ($items as $seat) {
            $seat = Seat::where('reference', '=', $seat['reference'])->first();

            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->type = 1;
            $orderItem->reference = $seat->reference;
            $orderItem->quantity = 1;

            $orderItem->unit_price = $seat->rate->price;
            $orderItem->subtotal = $orderItem->quantity * $orderItem->unit_price;

            $orderItem->created_at = Carbon::now();
            $orderItem->updated_at = Carbon::now();

            $orderItem->save();
        }

        // Calculate Order financials
        self::calculateTotal($order);

        return $order;
    }

    public static function updateOrder($reference, $items)
    {
        $order = Order::where('reference', '=', $reference)->first();

        // @TODO REFACTOR THIS CODE AND MAKE IT A FUNCTION
        foreach ($items as $seat) {
            $seat = Seat::where('reference', '=', $seat['reference'])->first();

            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->type = 1;
            $orderItem->reference = $seat->reference;
            $orderItem->quantity = 1;

            $orderItem->unit_price = $seat->rate->price;
            $orderItem->subtotal = $orderItem->quantity * $orderItem->unit_price;

            $orderItem->created_at = Carbon::now();
            $orderItem->updated_at = Carbon::now();

            $orderItem->save();
        }

        self::calculateTotal($order);

        return $order;
    }

    public static function calculateTotal($order)
    {
        $subtotal = 0;

        foreach ($order->items as $item) {
            $subtotal = $subtotal + $item->subtotal;

            // Only calculate ticket comissions for Euroleague
            if ($item->type === 1) {
                $order->comission = $order->comission + $subtotal * 0.05;
            }
        }

        $order->subtotal = $subtotal;
        $order->fee = $subtotal * 0.02;
        $order->tax = $subtotal * 0.18;
        $order->total = $subtotal + $order->fee;
        $order->updated_at = Carbon::now();
        $order->save();
    }

    public static function hasHotel($order)
    {
        $hotels = [];

        foreach ($order->items as $item) {
            if ($item->type === 2) {
                array_push($hotels, $item);
            }
        }

        if (count($hotels)) {
            return true;
        } else {
            return false;
        }
    }

    public static function appendUser($order, $user)
    {
        $order->user_id = $user->id;
        $order->updated_at = Carbon::now();
        $order->save();
    }
}

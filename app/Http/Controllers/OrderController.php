<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Topping;
use App\Models\Order_Topping;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index()
    {
        $orders = DB::table('orders')
            ->join('order__toppings', 'orders.id', '=', 'order__toppings.order_id')
            ->join('toppings', 'toppings.id', '=', 'order__toppings.topping_id')
            ->select('orders.*', 'toppings.name')
            ->get()
            ->groupBy('id')
            ->map(function ($group) {
                $order = $group->first();
                $order->toppings = $group->pluck('name');
                return $order;
            });

        return $orders;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'size' => 'required',
            'toppings' => 'required|array'
        ]);

        switch ($request->size) {
            case 'small': 
                $sizePrice = 8;
                break;
            case 'medium': 
                $sizePrice = 10;
                break;
            case 'large': 
                $sizePrice = 12;
                break;
        };

        $toppings = $request->toppings;
        $cost = $sizePrice;

        foreach( $toppings as $toppingId ) {
            $cost = $cost + Topping::find($toppingId)->price;
        };

        $discount = count($toppings) > 3 ? 10 : 0;
        $discountPrice = $discount > 0 ? $cost - ($cost * $discount/100) : null;

        $createdOrder = Order::create([
            'price' => $cost,
            'size' => $request->size,
            'discount' => $discount,
            'discount_price' => $discountPrice
        ]);

        foreach( $toppings as $toppingId ) {
            Order_Topping::create([
            'order_id' =>  $createdOrder->id,
            'topping_id' => $toppingId
            ]);
        };

        return $createdOrder;
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        {
            $order = DB::table('orders')
                ->join('order__toppings', 'orders.id', '=', 'order__toppings.order_id')
                ->join('toppings', 'toppings.id', '=', 'order__toppings.topping_id')
                ->select('orders.*', 'toppings.name')
                ->where('orders.id', $id)
                ->get()
                ->groupBy('id')
                ->map(function ($group) {
                    $order = $group->first();
                    $order->toppings = $group->pluck('name');
                    return $order;
                });
    
            return $order;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

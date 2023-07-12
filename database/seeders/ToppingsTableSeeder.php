<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Topping;
use App\Models\Order;
use App\Models\Order_Topping;


class ToppingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Topping::truncate();
        Order::truncate();
        Order_Topping::truncate();

        $toppings = array(
            'Tomato sauce',
            'Cheese',
            'Ham',
            'Chorizo',
            'Chicken',
            'Beef',
            'Mushrooms', 
            'Jalapenos', 
            'Bell peppers', 
            'Bacon', 
            'Pickles', 
            'Spinach'
        );

        foreach($toppings as $topping) {
            Topping::create([
                'name' => $topping,
                'price' => 1.00,
            ]);
        }

    }
}

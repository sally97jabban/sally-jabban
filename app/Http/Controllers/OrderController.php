<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_Item;
use App\Models\product;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{


    public function index(){

        $orders=Order::all();
        return $orders
        ;
    }

 public function orderStatus($id){
     // Sub_Category
     $state=Order::where('id',$id)->select('status')->get();
     return $state
     ;
 }

    private function createOrder(Request $request)
    { //total userid status productscount
        $order = new Order();
        $user_id = Auth::id();
        $order->user_id = $user_id;
        $order->total = $request->input('total');
        $order->status = 'confirmed';
        $order->latitude = $request->input('latitude');
        $order->longitude = $request->input('longitude');
        $order->date = $request->input('date');
        $order->items_count = 0;
        $order->save();
        return $order;
    }
    private function createOrderItem($id, $product_id,  $quantity,$color,$size,$price)
    {
        $product = product::findOrFail($product_id);
        $item = new Order_Item();
        $item->order_id = $id;
        $item->product_id =  $product_id;
        $item->quantity = $quantity;
        $item->color = $color;
        $item->size = $size;
        $item->price = $price;
        
        $item->save();
        
        return $item;
    }

    public function addOrder(Request $request)
    {
        
        $items_count = 0;
        $order = $this->createOrder($request);
        $products_count = $request->products_count;
        for ($i = 1; $i <= $products_count; $i++) {
            $product_id = $request['product_id_' . $i];
            $quantity = $request['quantity_' . $i];
            $color = $request['color_' . $i];
            $size = $request['size_' . $i];
            $price = $request['price_' . $i];
            $items_count += $request['quantity_' . $i];
            
            $items[$i] = $this->createOrderItem($order->id, $product_id, $quantity,$color,$size,$price);
        }
        $order->items_count= $items_count;
        $order->save();
        return $order;
    }

    public function allOrdersBystore($store_id){

    $orders=Store::Find($store_id)->orders()->get();
    return $orders;
       

    }

}

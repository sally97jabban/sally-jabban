<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\product;
use App\Models\Order;

class Order_Item extends Model
{
    protected $table ='order_items';
    protected $fillable = ['product_id','size','color'];
    use HasFactory;
    public function Product()
    {
        return $this->belongsTo(product::class);
    }
    public function Order()
    {
        return $this->belongsTo(Order::class);
    }
}
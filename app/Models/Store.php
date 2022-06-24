<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sub_Category;
use App\Models\product;
use App\Models\Order;

class Store extends Model
{
    use HasFactory;
    public function subCategories()
    {
        return $this->belongsToMany(Sub_Category::class);
    }
    public function Products()
    {
        return $this->hasMany(product::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

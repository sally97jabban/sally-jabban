<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Store;


class Order extends Model
{
    use HasFactory;
    public function OrderItems()
    {
        return $this->hasMany(Order_Item::class);
    }
    public function User()
    {
        return $this->belongsTo(User::class);
    }
    public function Store()
    {

        return $this->belongsTo(Store::class);
    }
    
}

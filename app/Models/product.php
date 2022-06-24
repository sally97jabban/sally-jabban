<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Store;
use App\Models\Sub_Category;
use App\Models\Order_Detaile;
use App\Models\Favorite;
use App\Models\Color;
use App\Models\Size;

class product extends Model
{
    protected $table = 'products';
    use HasFactory;
    protected $fillable =
    ['name',
    'price',
    'description',
    'image',
    'discount',
    'category_id',
    'store_id',
    'subcategory_id'];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function Store()
    {
        return $this->belongsTo(Store::class);
    }
    public function subCategories()
    {
        return $this->belongsTo(Sub_Category::class);
    }
    public function OrderDetailes()
    {
        return $this->hasMany(Order_Detaile::class);
    }
    public function favorites()
    {
        return $this->belongsToMany(Favorite::class);
    }
    public function colors()
    {
        return $this->belongsToMany(Color::class,'product_color');//,'color_id','product_id');
    }
    public function sizes()
    {
        return $this->belongsToMany(Size::class,'product_size');
    }
}

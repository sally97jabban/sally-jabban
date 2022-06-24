<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\product;
use App\Models\Category;
use App\Models\Store;

class Sub_Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'sub_name',
        'cover',
        'category_id',
    
    ];
    protected $table="sub_categories";
    public function Product()
    {
        return $this->hasMany(product::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function stores()
    {
        return $this->belongsToMany(Store::class);

    }

}

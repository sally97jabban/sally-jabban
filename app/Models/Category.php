<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sub_Category;
use App\Models\product;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'cover',
        
    
    ];
    public function subCategories()
    {
        return $this->hasMany(Sub_Category::class);
    }
    public function Product()
    {
        return $this->hasMany(product::class);
    }
}

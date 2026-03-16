<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
    protected $fillable = ['name', 'description', 'price', 'stock', 'category_id'];
    protected $table = 'products';
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products')->withPivot('quantity', 'unit_price')->withTimestamps();
    }
    public function images()
    {
        return $this->hasMany(Image::class);
    }
}

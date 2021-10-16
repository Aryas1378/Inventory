<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'category_id',
        'brand_id',
        'code',
        'status_id',
        'is_public',
    ];

    const available = 1;
    const loaned = 2;

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'user_product');
    }

    public static function isAvailable($id)
    {
        $product = Product::query()->where('id', '=',$id)->get();

        if ($product->toArray()){
            return true;
        }
        return false;
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\True_;

class UserProduct extends Model
{

    use HasFactory;

    protected $table = 'user_product';
    protected $fillable = [
        'user_id',
        'product_id',
        'code',
        'from_date',
        'to_date',
        'status_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public static function isAvailable($user_id, $product_id)
    {
        if (UserProduct::query()->where(['user_id' => $user_id], ['product_id' => $product_id])->count()){
            return true;
        }
        return false;
    }

}

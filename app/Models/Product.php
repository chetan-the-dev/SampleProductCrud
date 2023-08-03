<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function product_variant(){
        return $this->hasMany(ProductVariant::class,'product_id','id');
    }

    public static function createProduct($request)
    {
        $product = Product::create($request);
        return $product;
    }

    //Update product data based on array values
    public static function updateProductBySourceId($request,$id)
    {
        $store = Product::where('id',$id)->update($request);
        return $store;
    }
}

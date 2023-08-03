<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Update product variation based on array column list given
    public static function updateProductVariantByProductId($request,$id)
    {
        $ProductVariant = ProductVariant::where('id',$id)->update($request);
        return $ProductVariant;
    }
}

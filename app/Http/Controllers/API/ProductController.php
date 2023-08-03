<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    

    public function demo(){
        
    }
    /**
     * Add product to database.
     */
    public function addProduct(Request $request)
    {        
        //return $request->all();
        try {
            $addData = array(
                'product_name' => $request['title'],
                'product_category'=>$request['product_category'],
                'product_description' => $request['body_html'],
                'product_slug' => $request['slug'],
                'status' => $request['status'] == 'active' ? 1 : 0,
                'product_tags' => $request['tags'],
                'product_vendor' => $request['vendor']
            );
    
            $add_product = Product::createProduct($addData);
            
            if($add_product){
                $product_variation = [];
            
                foreach($request['variants'] as $variants){
                    $product_variant['product_id'] = $add_product->id;
                    $product_variant['product_variant_price'] = $variants['compare_at_price'] > 0 ? $variants['compare_at_price'] : $variants['price'];
                    $product_variant['product_variant_discount_price'] = $variants['compare_at_price'] > 0 ? $variants['price'] : null;
                    $product_variant['weight_in_gram'] = $variants['grams'];
                    $product_variant['weight'] = $variants['weight'];
                    $product_variant['weight_unit'] = $variants['weight_unit'];
                    $product_variant['product_variant_qty'] = $variants['inventory_quantity'];
                    $product_variant['product_variant_position'] = $variants['position'];
                    $product_variant['product_variant_sku'] = $variants['sku'];
                    $variants_json = array();
                    foreach($request['options'] as $key=>$option){
                        $variants_data[$option['name']]=$variants['option'.$key+1];
                        array_push($variants_json,$variants_data);
                    }
                    $product_variant['product_variant_info'] = json_encode($variants_json);
                    $product_variant['product_variant_name'] = $variants['title'];
                    

                    array_push($product_variation,$product_variant);
                }

                if(count($product_variation)>0){
                    ProductVariant::insert($product_variation);
                }   

                Log::info("Product added");
                return response()->json(['success' => true]);
            }else{
                Log::info("Product not added");
                return response()->json(['success' => false]);
            }
        } catch (\Exception $e) {
            Log::error("Error in product add:".$e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update product.
     */
    public function editProduct(Request $request)
    {
        try {
            $getProduct = Product::where('id',$request['id'])->count();
            if($getProduct>0){
                $editData = array(
                    'product_name' => $request['title'],
                    'product_category'=>$request['product_category'],
                    'product_description' => $request['body_html'],
                    'product_slug' => $request['slug'],
                    'status' => $request['status'] == 'active' ? 1 : 0,
                    'product_tags' => $request['tags'],
                    'product_vendor' => $request['vendor']
                );
        
                Product::updateProductBySourceId($editData,$request['id']);
                        
                foreach($request['variants'] as $variants){
                    $product_variant = array();
                    $product_variant['product_variant_price'] = $variants['compare_at_price'] > 0 ? $variants['compare_at_price'] : $variants['price'];
                    $product_variant['product_variant_discount_price'] = $variants['compare_at_price'] > 0 ? $variants['price'] : null;
                    $product_variant['weight_in_gram'] = $variants['grams'];
                    $product_variant['weight'] = $variants['weight'];
                    $product_variant['weight_unit'] = $variants['weight_unit'];
                    $product_variant['product_variant_qty'] = $variants['inventory_quantity'];
                    $product_variant['product_variant_position'] = $variants['position'];
                    $product_variant['product_variant_sku'] = $variants['sku'];
                    $variants_json = array();
                    foreach($request['options'] as $key=>$option){
                        $variants_data[$option['name']]=$variants['option'.$key+1];
                        array_push($variants_json,$variants_data);
                    }
                    $product_variant['product_variant_info'] = json_encode($variants_json);
                    $product_variant['product_variant_name'] = $variants['title'];
                    
                    ProductVariant::updateProductVariantByProductId($product_variant,$variants['id']);
                }

                Log::info("Product updated");
                return response()->json(['success' => true]);
            }else{
                $logMessage = 'No product found with given details : ' . json_encode($request->all());
                Log::error($logMessage);
                return response()->json(['success' => false, 'error' => 'Invalid Data'], 400);
            }
            
        } catch (\Exception $e) {
            Log::error("Update product error:".$e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
        
    }

    /**
     * Get list of product.
     */
    public function getProduct()
    {
        try {
            $getProduct = Product::with('product_variant')->whereStatus(1)->get();
            return response()->json(['success' => true, 'msg' => 'List of product','data'=>$getProduct], 200);
        } catch (\Exception $e) {
            Log::error("Get product error:".$e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get detail of product.
     */
    public function getProductByid($id)
    {
        try {
            $getProduct = Product::with('product_variant')->whereStatus(1)->find($id);
            if($getProduct){
                return response()->json(['success' => true, 'msg' => 'Product detail','data'=>$getProduct], 200);
            }else{
                return response()->json(['success' => false, 'msg' => 'Invalid data sent'], 400);
            }
        } catch (\Exception $e) {
            Log::error("Get product error:".$e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Delete product.
     */
    public function deleteProduct($id)
    {
        try {
            $getProduct = Product::find($id);
            if($getProduct){
                $getProduct->delete();
                return response()->json(['success' => true, 'msg' => 'Product deleted'], 200);
            }else{
                return response()->json(['success' => false, 'msg' => 'Invalid data sent'], 400);
            }
        } catch (\Exception $e) {
            Log::error("Get product error:".$e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
    
}

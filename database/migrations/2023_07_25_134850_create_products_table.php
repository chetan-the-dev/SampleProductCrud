<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->text('product_name');
            $table->text('product_description')->nullable();
            $table->text('product_slug');
            $table->text('product_category')->nullable(true);
            $table->integer('status')->default(1);
            $table->text('product_tags')->nullable();
            $table->text('product_vendor')->nullable();
            $table->boolean('is_variable_product')->default(false);
            $table->float('product_price')->default(0);
            $table->float('product_discount_price')->default(0);
            $table->integer('product_qty')->default(0);
            $table->text('product_sku')->nullable(true);
            $table->float('weight_in_gram')->nullable(true);
            $table->float('weight')->nullable(true);
            $table->char('weight_unit', 100)->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

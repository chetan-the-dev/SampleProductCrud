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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->references('id')->on('products')->cascadeOnDelete();
            $table->float('product_variant_price');
            $table->text('product_variant_name');
            $table->longText('product_variant_info');
            $table->integer('status')->default(1);
            $table->float('product_variant_discount_price')->nullable(true);
            $table->float('weight_in_gram')->nullable(true);
            $table->float('weight')->nullable(true);
            $table->char('weight_unit', 100)->nullable(true);
            $table->integer('product_variant_qty')->default(0);
            $table->integer('product_variant_position')->default(1);
            $table->text('product_variant_sku')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};

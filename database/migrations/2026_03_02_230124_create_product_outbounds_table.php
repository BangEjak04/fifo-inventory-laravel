<?php

use App\Models\ProductInbound;
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
        Schema::create('product_outbounds', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ProductInbound::class)->constrained()->cascadeOnDelete();
            $table->integer('quantity_in');
            $table->date('outbound_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_outbounds');
    }
};

<?php

use App\Enums\ProductionSession;
use App\Models\Product;
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
        Schema::create('product_inbounds', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class)->constrained()->cascadeOnDelete();
            $table->date('production_date');
            $table->enum('session', ProductionSession::cases());
            $table->date('expired_date');
            $table->integer('quantity_in');
            $table->integer('quantity_remaining');
            $table->string('barcode')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_inbounds');
    }
};

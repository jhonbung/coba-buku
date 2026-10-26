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
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();
            $table->string('series_name')->nullable(); // e.g., 'The Seven Notonegoro Series I'
            $table->enum('category', ['novel', 'ebook', 'merchandise'])->default('novel');
            $table->string('subcategory')->default('notonegoro'); // notonegoro, standalone, limited, chapter
            $table->string('author')->default('Bianca Veana');
            $table->decimal('price', 12, 0);
            $table->decimal('original_price', 12, 0)->nullable();
            $table->integer('stock')->default(50);
            $table->string('cover_image')->nullable();
            $table->text('synopsis')->nullable();
            $table->string('genre')->default('Romance, Royal, Drama');
            $table->integer('pages')->nullable();
            $table->integer('weight_grams')->default(350);
            $table->string('dimensions')->nullable();
            $table->string('publisher')->default('Bianca Veana Publishing');
            $table->string('isbn')->nullable();
            $table->json('collectors_items')->nullable(); // e.g. ["Book Jacket", "Exclusive Photocard", "Signature Card", "Gold Foil Bookmark"]
            $table->string('digital_file_type')->nullable(); // 'pdf' or 'gdrive'
            $table->text('digital_file_url')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_preorder')->default(false);
            $table->integer('order_index')->default(0);
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->text('shipping_address');
            $table->string('city');
            $table->string('postal_code');
            $table->string('courier')->default('JNE REG');
            $table->decimal('shipping_cost', 12, 0)->default(0);
            $table->decimal('subtotal', 12, 0);
            $table->decimal('total_amount', 12, 0);
            $table->string('payment_method')->default('qris');
            $table->string('payment_status')->default('paid'); // pending, paid, failed
            $table->string('order_status')->default('processing'); // pending, processing, shipped, completed, cancelled
            $table->string('tracking_number')->nullable();
            $table->boolean('digital_delivered')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->string('product_title');
            $table->decimal('price', 12, 0);
            $table->integer('quantity')->default(1);
            $table->decimal('subtotal', 12, 0);
            $table->text('digital_access_url')->nullable();
            $table->timestamps();
        });

        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->text('quote');
            $table->string('character_name');
            $table->string('book_title');
            $table->integer('order_index')->default(0);
            $table->timestamps();
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('reviewer_name');
            $table->string('book_title');
            $table->integer('rating')->default(5);
            $table->text('comment');
            $table->timestamps();
        });

        Schema::create('newsletter_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsletter_subscribers');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('quotes');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('products');
    }
};

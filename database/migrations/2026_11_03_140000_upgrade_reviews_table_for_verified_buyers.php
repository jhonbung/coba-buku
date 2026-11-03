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
        Schema::table('reviews', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
            $table->foreignId('product_id')->nullable()->after('user_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('order_id')->nullable()->after('product_id')->constrained('orders')->nullOnDelete();
            $table->string('reviewer_email')->nullable()->after('reviewer_name');
            $table->string('variant_name')->nullable()->after('book_title');
            $table->string('review_title')->nullable()->after('rating');
            $table->string('photo_url')->nullable()->after('comment');
            $table->boolean('is_verified_buyer')->default(true)->after('photo_url');
            $table->boolean('is_approved')->default(true)->after('is_verified_buyer');
            $table->text('admin_reply')->nullable()->after('is_approved');
            $table->timestamp('admin_replied_at')->nullable()->after('admin_reply');
            $table->integer('helpful_count')->default(0)->after('admin_replied_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['product_id']);
            $table->dropForeign(['order_id']);
            $table->dropColumn([
                'user_id',
                'product_id',
                'order_id',
                'reviewer_email',
                'variant_name',
                'review_title',
                'photo_url',
                'is_verified_buyer',
                'is_approved',
                'admin_reply',
                'admin_replied_at',
                'helpful_count',
            ]);
        });
    }
};


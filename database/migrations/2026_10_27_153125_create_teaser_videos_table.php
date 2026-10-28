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
        Schema::create('teaser_videos', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Eksplorasi Semesta Bianca Veana');
            $table->string('tagline')->nullable()->default('OFFICIAL CINEMATIC TRAILER');
            $table->text('subtitle')->nullable();
            $table->enum('video_type', ['file', 'youtube', 'url'])->default('file');
            $table->string('video_path')->nullable();
            $table->text('youtube_url')->nullable();
            $table->string('thumbnail_path')->nullable();
            $table->string('badge_1')->nullable()->default('1080p Full HD');
            $table->string('badge_2')->nullable()->default('Original Soundtrack');
            $table->string('badge_3')->nullable()->default('Official Universe');
            $table->string('cta_text')->nullable()->default('Beli Seri Novel');
            $table->string('cta_link')->nullable()->default('#notonegoro-series');
            $table->boolean('is_active')->default(true);
            $table->integer('order_index')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teaser_videos');
    }
};

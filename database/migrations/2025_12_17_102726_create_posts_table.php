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
    Schema::create('posts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // The Author
        $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete(); // The Category
        $table->string('title');
        $table->string('slug')->unique(); // URL: /blog/my-first-post
        $table->text('excerpt')->nullable(); // Short summary
        $table->longText('content'); // The full article (Rich Text)
        $table->string('image')->nullable(); // Cover image
        $table->enum('status', ['draft', 'published'])->default('draft');
        $table->timestamp('published_at')->nullable();
        $table->boolean('is_featured')->default(false);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};

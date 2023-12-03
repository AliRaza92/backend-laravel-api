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
        Schema::create('news', function (Blueprint $table) {
            $table->id(); // Primary key for the table
            
            // Nullable string to store the URL. Maximum length set to 2024 characters.
            $table->string('url', 2024)->nullable(); 

            // Nullable string to store the author's name.
            $table->string('author')->nullable(); 

            // Nullable text field to store the title. Text type is used for longer content.
            $table->text('title')->nullable();

            // Nullable text field to store a brief description.
            $table->text('description')->nullable();

            // Nullable datetime field to store the publication date and time.
            $table->timestamp('publishedAt')->nullable();

            // Nullable text field to store the main content.
            $table->text('content')->nullable();

            // Nullable string to store the source of the information.
            $table->string('source')->nullable();

            // Nullable string to store the category of the content.
            $table->string('category')->nullable();

            // Laravel's default timestamp fields to store created_at and updated_at dates.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};

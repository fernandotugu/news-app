<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();

            $table->uuid('uuid')->unique();

            $table->string('title');
            $table->text('content');

            $table->foreignId('category_id')
                ->constrained('news_categories')
                ->cascadeOnDelete();

            $table->dateTime('published_at')->nullable();

            $table->timestamps();

            $table->index('category_id');
        });
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            // Drop FK antes de dropar tabela (boa prática)
            $table->dropForeign(['category_id']);
        });

        Schema::dropIfExists('news');
    }
};

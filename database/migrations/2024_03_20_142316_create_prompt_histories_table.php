<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('prompt_histories', function (Blueprint $table) {
            $table->id();
            $table->longText('input')->nullable();
            $table->longText('output')->nullable();
            $table->integer('input_tokens');
            $table->integer('output_tokens');
            $table->string('system_fingerprint')->nullable();
            $table->string('gpt_model');
            $table->string('session_token')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prompt_histories');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('session_tokens', function (Blueprint $table) {
            $table->unsignedBigInteger('game_code_id')->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('session_tokens', function (Blueprint $table) {
            //
        });
    }
};

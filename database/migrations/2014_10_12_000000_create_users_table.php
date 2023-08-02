<?php

use App\Models\Personnel;
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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('type',['ADMINISTRATOR','FSIC','FSEC','FIREDRILL']);
            $table->string('name');
            $table->string('reset_password')->nullable();
            $table->boolean('is_password_default')->default(true);
            $table->boolean('request_password_reset')->default(false);
            $table->foreignIdFor(Personnel::class)->unique()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

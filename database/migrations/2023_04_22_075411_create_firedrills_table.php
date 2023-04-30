<?php

use App\Models\Establishment;
use App\Models\Receipt;
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
        Schema::create('firedrills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('control_no')->nullable();
            $table->string('validity_term')->nullable();
            $table->date('date_claimed')->nullable();
            $table->string('issued_on')->nullable();
            $table->string('date_made')->nullable();
            $table->string('year')->nullable();
            $table->foreignIdFor(Establishment::class);
            $table->foreignIdFor(Receipt::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('firedrills');
    }
};

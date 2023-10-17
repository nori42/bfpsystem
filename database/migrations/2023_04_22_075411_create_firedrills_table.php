<?php

use App\Models\Establishment;
use App\Models\Receipt;
use App\Models\User;
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
            $table->string('control_no')->unique()->nullable();
            $table->string('validity_term')->nullable();
            $table->date('date_claimed')->nullable();
            $table->date('issued_on')->nullable();
            $table->date('date_made')->nullable();
            $table->enum('term_type',['SEMESTER','QUARTERLY']);
            $table->string('claimed_by')->nullable();
            $table->string('year')->nullable();
            $table->foreignIdFor(User::class)->nullable();
            $table->foreignIdFor(Establishment::class);
            $table->foreignIdFor(Receipt::class);
            $table->timestamps();
            $table->softDeletes();
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

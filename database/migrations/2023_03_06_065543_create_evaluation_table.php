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
        Schema::create('evaluation', function (Blueprint $table) {
            $table->id();
            $table->integer('record_no');
            $table->string('or_no');
            $table->string('amount_paid', 15, 8);
            $table->string('certification_no');
            $table->string('printed_by');
            $table->dateTime('date_printed')->nullable();
            $table->dateTime('date_of_payment');
            $table->dateTime('date_release');
            $table->string('evaluator');
            $table->string('boq');
            $table->string('remarks');
            $table->string('purpose');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation');
    }
};

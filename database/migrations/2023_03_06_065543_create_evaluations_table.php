<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Establishment;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Establishment::class);
            $table->integer('record_no')->nullable();
            $table->string('or_no');
            $table->string('amount_paid', 15, 8);
            $table->string('certification_no');
            $table->string('printed_by');
            $table->dateTime('date_printed')->nullable();
            $table->dateTime('date_of_payment');
            $table->dateTime('date_release');
            $table->string('evaluator')->nullable();;
            $table->string('billOfMaterials')->nullable();;
            $table->string('remarks')->nullable();;
            $table->string('purpose')->nullable();;
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

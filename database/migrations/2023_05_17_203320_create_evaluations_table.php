<?php

use App\Models\BuildingPlan;
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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('evaluator');
            $table->enum('remarks',['APPROVED','PENDING','DISAPPROVED']);
            $table->string('disapprove_print_path')->nullable();
            $table->string('checklist_print_path')->nullable();
            $table->foreignIdFor(BuildingPlan::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};

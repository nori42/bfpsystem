<?php

use App\Models\Building;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Establishment;
use App\Models\Owner;
use App\Models\Receipt;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('building_plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('project_title')->nullable();
            $table->string('name_of_building')->nullable();
            $table->string('series_no')->nullable();
            $table->string('bp_application_no')->nullable();
            $table->string('bill_of_materials')->nullable();
            $table->date('date_received')->nullable();
            $table->date('date_released')->nullable();
            $table->enum('status',['APPROVED','DISAPPROVED','PENDING'])->default('PENDING');
            $table->foreignIdFor(Owner::class);
            $table->foreignIdFor(Building::class);
            $table->foreignIdFor(Receipt::class);
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

<?php

use App\Models\Owner;
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
        Schema::create('establishments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('establishment_name');
            $table->string('substation')->nullable();;
            $table->string('occupancy')->nullable();;
            $table->string('sub_type')->nullable();;
            $table->string('building_type')->nullable();;
            $table->string('no_of_storey')->nullable();
            $table->string('height')->nullable();
            $table->string('floor_area')->nullable();
            $table->string('hazard_note')->nullable();
            $table->string('business_permit_no')->nullable();
            $table->string('building_permit_no')->nullable();
            $table->string('fire_insurance_co')->nullable();
            $table->string('barangay')->nullable();
            $table->string('address')->nullable();
            $table->string('createdBy')->nullable();
            $table->boolean('inspection_is_expired');
            $table->boolean('firedrill_is_expired');
            $table->integer('firedrill_count_yearly')->nullable();
            $table->enum('firedrill_type',['QUARTERLY','SEMESTER'])->nullable();
            $table->foreignIdFor(Owner::class);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('establishments');
    }
};

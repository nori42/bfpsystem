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
            $table->bigIncrements('record_no');
            $table->string('establishment_name');
            $table->string('corporate_name');
            $table->string('substation');
            $table->string('sub_type');
            $table->string('building_type');
            $table->string('no_of_story');
            $table->string('height');
            $table->string('building_permit_no');
            $table->string('fire_insurance_co');
            $table->string('latest_permit');
            $table->string('barangay');
            $table->string('address');
            $table->foreignIdFor(Owner::class);
            $table->string('status');
            $table->string('createdBy');
            $table->timestamps();
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

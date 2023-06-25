<?php

use App\Models\Person;
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

        Schema::create('personnel', function (Blueprint $table) {
            $ranks = array('CINSP','INSP','SFO4','SFO3','SFO2','SFO1','FO3','FO2','FO1','NUP');

            $table->bigIncrements('id');
            $table->string('sex')->nullable();
            $table->enum('rank',$ranks);
            $table->string('designation')->nullable();
            $table->string('pagibig_no')->nullable();
            $table->string('philhealth_no')->nullable();
            $table->string('TINNo')->nullable();
            $table->boolean('has_user')->nullable();
            $table->foreignIdFor(Person::class)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personnel');
    }
};

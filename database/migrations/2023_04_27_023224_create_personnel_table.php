<?php

use App\Models\Person;
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

        Schema::create('personnel', function (Blueprint $table) {
            $ranks = array('CINSP','INSP','SFO4','SFO3','SFO2','SFO1','FO3','FO2','FO1','NUP');

            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('name_suffix')->nullable();
            $table->string('sex')->nullable();
            $table->date('date_of_birth');
            $table->string('address')->nullable();
            $table->string('contact_no')->nullable();
            $table->enum('rank',$ranks);
            $table->foreignIdFor(User::class);
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

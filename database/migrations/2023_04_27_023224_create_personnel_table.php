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
            $table->bigIncrements('id');
            $table->string('sex')->nullable();
            $table->string('rank')->nullable();
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

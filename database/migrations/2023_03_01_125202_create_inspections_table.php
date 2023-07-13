<?php

use App\Models\Establishment;
use App\Models\Payment;
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
        Schema::create('inspections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('inspection_date');
            // $table->string('building_conditions')->nullable();
            $table->string('note')->nullable();
            // $table->string('building_structures')->nullable();
            $table->string('registration_status')->nullable();
            $table->string('fsic_no')->nullable();
            $table->enum('status',['Not Printed','Printed'])->default("Not Printed");
            $table->date('issued_on')->nullable();
            $table->date('expiry_date')->nullable();
            $table->foreignIdFor(User::class)->nullable();
            $table->foreignIdFor(Receipt::class);
            $table->foreignIdFor(Establishment::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};

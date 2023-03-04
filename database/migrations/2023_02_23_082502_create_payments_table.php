<?php

use App\Models\Establishment;
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
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignIdFor(Establishment::class);
            $table->string('or_no');
            $table->string('nature_of_payment');
            $table->string('amount_paid', 15, 8);
            $table->string('certification');
            $table->string('status');
            $table->string('printed_by');
            $table->string('issued_for');
            $table->string('building_condition');
            $table->string('building_structures');
            $table->dateTime('expiry_date');
            $table->dateTime('date_of_payment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

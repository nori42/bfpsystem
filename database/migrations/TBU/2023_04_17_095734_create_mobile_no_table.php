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
        Schema::create('mobile_no', function (Blueprint $table) {
            $table->id('mobile_no');
            $table->string('owned_by');
            $table->foreignIdFor(Owner::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobile_no');
    }
};

<?php

use App\Models\Corporate;
use App\Models\Owner;
use App\Models\Personnel;
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
            $table->string('owner_name');
            $table->foreignIdFor(Person::class);
            $table->foreignIdFor(Corporate::class);
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

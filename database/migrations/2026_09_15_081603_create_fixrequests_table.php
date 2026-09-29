<?php

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
        Schema::create('fixrequests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worktime_id')->constrained()->cascadeOnDelete();
            $table->datetime('clock_in');
            $table->datetime('clock_out');
            $table->datetime('break_in')->nullable();
            $table->datetime('break_out')->nullable();
            $table->string('contant');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixrequests');
    }
};

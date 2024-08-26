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
        Schema::create('user_shelter', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('shelter_id');
            $table->boolean('owner')->default(false);

            $table->primary(['user_id', 'shelter_id']);
            $table->foreign('shelter_id')->references('id')->on('shelters')->cascadeOnUpdate();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_shelter');
    }
};

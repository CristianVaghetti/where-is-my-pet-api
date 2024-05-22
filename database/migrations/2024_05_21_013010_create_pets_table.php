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
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('shelter_id');
            $table->unsignedInteger('type_id');
            $table->string('image');
            $table->string('personality');
            $table->boolean('found')->default(false);
            $table->string('owner_name')->nullable();
            $table->string('owner_email')->nullable();
            $table->string('owner_phone')->nullable();
            $table->timestamps();

            $table->foreign('shelter_id')->references('id')->on('shelters')->cascadeOnUpdate();
            $table->foreign('type_id')->references('id')->on('pet_types')->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};

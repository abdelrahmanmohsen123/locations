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
        Schema::create('store_branches', function (Blueprint $table) {
            $table->id();
            $table->string('name_en',200);
            $table->string('name_ar',200);
            $table->string('lat',255);
            $table->string('lng',255);
            $table->boolean('status')->default(true);

            $table->unsignedBigInteger('store_id')->index();
            $table->foreign('store_id')->references('id')->on('stores')->onUpdate('CASCADE')->onDelete('RESTRICT');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_branches');
    }
};
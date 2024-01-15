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
        Schema::create('images', function (Blueprint $table) {
            $table->id()->startingValue(10000000);
            $table->bigInteger('user_id');
            $table->bigInteger('project_id');
            $table->bigInteger('parent_id')->nullable()->default(0);
            $table->string('file_name')->nullable()->default("");
            $table->string('file_path')->nullable()->default("");
            $table->bigInteger('size')->nullable();
            $table->bigInteger('top')->default(0);
            $table->bigInteger('left')->default(0);
            $table->bigInteger('width')->default(0);
            $table->bigInteger('height')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};

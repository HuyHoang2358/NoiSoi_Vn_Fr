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
        Schema::create('label_answers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("image_id");
            $table->bigInteger("label_id");
            $table->bigInteger("user_id")->default(-1); # AI ans = -1
            $table->float("accuracy")->default(0.0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('label_answers');
    }
};

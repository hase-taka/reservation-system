<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('area_id')->constrained()->onDelete('cascade');
            $table->foreignId('genre_id')->constrained()->onDelete('cascade');
            $table->string('content');
            $table->string('img_url')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_path')->nullable();
            // $table->foreignId('representative_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('representative_id')->nullable();
            $table->foreign('representative_id')->references('id')->on('users')->onDelete('set null');
            $table->boolean('has_menu')->default(false)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurants');
    }
}

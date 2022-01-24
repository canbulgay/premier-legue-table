<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixtures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('home_id')->constrained('teams');
            $table->foreignId('away_id')->constrained('teams');
            $table->integer('home_result')->nullable();
            $table->integer('away_result')->nullable();
            $table->enum('is_played',['played','not_played'])->default('not_played');
            $table->dateTime('start_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fixtures');
    }
}

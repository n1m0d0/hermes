<?php

use App\Models\Flight;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('airline_id');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('destiny_id');
            $table->time('exit');
            $table->enum('status', [
                Flight::Active,
                Flight::Inactive
            ])->default(Flight::Active);
            $table->timestamps();

            $table->foreign('airline_id')->references('id')->on('airlines');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('destiny_id')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flights');
    }
};

<?php

use App\Models\Service;
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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');            
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('destiny_id');
            $table->enum('type', [
                Service::Shipping,
                Service::Order
            ]);
            $table->string('description');
            $table->mediumText('photo');
            $table->enum('status', [
                Service::Active,
                Service::Inactive,
                Service::Processing,
                Service::Finalized
            ])->default(Service::Active);
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients');
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
        Schema::dropIfExists('services');
    }
};

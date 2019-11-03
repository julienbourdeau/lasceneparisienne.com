<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venues', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');
            $table->text('description')->nullable();
            $table->string('slug');
            $table->json('cover')->nullable();

            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('country_code', 5)->nullable();

            $table->string('address_formatted')->nullable();
            $table->string('phone_formatted')->nullable();
            $table->string('email')->nullable();
            $table->json('opening_hours')->nullable();

            $table->decimal('lat', 10, 8)->nullable();
            $table->decimal('lng', 11, 8)->nullable();

            $table->json('meta')->nullable();

            $table->uuid('uuid');

            $table->string('id_facebook')->nullable();
            $table->json('source')->nullable();


            $table->softDeletes();
            $table->timestamps();


            $table->index('slug');
            $table->index('city');
            $table->index('id_facebook');
            $table->index('uuid');
            $table->unique(['id_facebook', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('venues');
    }
}

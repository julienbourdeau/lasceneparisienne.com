<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('venue_id');
            $table->foreign('venue_id')->references('id')->on('venues');

            $table->string('name');
            $table->string('slug');

            $table->timestamp('start_time');
            $table->timestamp('end_time')->nullable();

            $table->text('description')->nullable();
            $table->json('cover')->nullable();
            $table->boolean('canceled')->default(0);
            $table->boolean('soldout')->default(0);

            $table->text('ticket_url')->nullable();

            $table->json('meta')->nullable();

            $table->string('id_facebook', 64)->nullable();
            $table->uuid('uuid');

            $table->timestamp('fb_updated_at')->nullable();
            $table->timestamp('last_pulled_at')->nullable();
            $table->softDeletes();
            $table->timestamps();


            $table->index('slug');
            $table->index('start_time');
            $table->index('end_time');
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
        Schema::dropIfExists('events');
    }
}

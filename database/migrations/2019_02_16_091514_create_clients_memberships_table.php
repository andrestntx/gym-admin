<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsMembershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients_memberships', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->date('start_at');

            $table->date('end_at')->nullable();

            $table->unsignedInteger('client_id');
            $table->foreign('client_id')
                ->references('id')
                ->on('clients');

            $table->unsignedInteger('membership_id');
            $table->foreign('membership_id')
                ->references('id')
                ->on('memberships');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients_memberships');
    }
}

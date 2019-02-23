<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balances', function (Blueprint $table) {
            $table->increments('id');

            $table->string('comments');

            $table->double("init_base");

            $table->double("spent");
            $table->double("sold");
            $table->double("sold_memberships");

            $table->double("balance");
            $table->double("real_balance");

            $table->double("new_base");
            $table->double("saved_money");

            $table->date('closed_at');

            $table->timestamps();

            $table->unsignedInteger('user_id')->default(1);
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('balances');
    }
}

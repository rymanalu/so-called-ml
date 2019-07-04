<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditCardDefaultClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_card_default_clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('limit_balance', 19, 4);
            $table->tinyInteger('sex');
            $table->tinyInteger('education');
            $table->tinyInteger('marital_status');
            $table->unsignedInteger('age');

            for ($i = 1; $i <= 6; $i++) {
                $table->integer('pay_' . $i);
            }

            for ($i = 1; $i <= 6; $i++) {
                $table->decimal('bill_statement_' . $i, 19, 4);
            }

            for ($i = 1; $i <= 6; $i++) {
                $table->decimal('previous_payment_' . $i, 19, 4);
            }

            $table->boolean('is_next_month_default');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credit_card_default_clients');
    }
}

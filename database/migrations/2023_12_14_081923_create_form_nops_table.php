<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormNopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_nops', function (Blueprint $table) {
            $table->increments('nop_id');
            $table->string('nop_name')->nullable();
            $table->unsignedInteger('purpay_id')->nullable();
            $table->string('acc_name')->nullable();
            $table->string('provider')->nullable();
            $table->string('bank_name')->nullable();
            $table->unsignedInteger('amount_id')->nullable();
            $table->integer('account_no')->nullable();
            $table->date('due_date')->nullable();
            $table->string('email')->unique();
            $table->longText('other_info')->nullable();
            $table->longText('desc')->nullable();
            $table->longText('explanation')->nullable();
            $table->string('prep_by')->nullable();
            $table->string('rev_by')->nullable();
            $table->string('appr_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('amount_id')->references('amount_id')->on('amounts')->onDelete('cascade');
            $table->foreign('purpay_id')->references('purpay_id')->on('purpose_payments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_nops');
    }
}

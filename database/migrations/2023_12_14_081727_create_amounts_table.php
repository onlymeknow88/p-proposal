<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amounts', function (Blueprint $table) {
            $table->increments('amount_id');
            $table->unsignedInteger('gl_acc_id')->nullable();
            $table->integer('amount')->nullable();
            $table->year('year')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('gl_acc_id')->references('gl_acc_id')->on('gl_accs')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('amounts');
    }
}

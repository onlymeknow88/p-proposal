<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGlAccsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gl_accs', function (Blueprint $table) {
            $table->increments('gl_acc_id');
            $table->unsignedInteger('ccow_id')->nullable();
            $table->string('gl_account')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('ccow_id')->references('ccow_id')->on('ccows')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gl_accs');
    }
}

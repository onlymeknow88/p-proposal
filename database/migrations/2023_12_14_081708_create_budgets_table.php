<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->increments('budget_id');
            $table->unsignedInteger('ccow_id')->nullable();
            $table->string('budget_name')->nullable();
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
        Schema::dropIfExists('budgets');
    }
}

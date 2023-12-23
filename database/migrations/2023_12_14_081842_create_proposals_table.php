<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->increments('prop_id');
            $table->string('prop_no')->nullable();
            $table->date('start_date')->nullable();
            $table->date('receive_date')->nullable();
            $table->string('emp_name')->nullable();
            $table->string("judul")->nullable();
            $table->string("pengirim")->nullable();
            $table->unsignedInteger('area_id')->nullable();
            $table->longText("perm_bantuan")->nullable();
            $table->enum("jenis_bantuan", ["dana", "material"])->nullable();
            $table->enum("skala_prioritas", ["low", "medium", "high"])->nullable();
            $table->unsignedInteger("budget_id")->nullable();
            $table->integer("jumlah_bantuan")->nullable()->default(0);
            $table->longText('ass_proposal')->nullable();
            $table->bigInteger("status")->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('area_id')->references('area_id')->on('areas')->onDelete('cascade');
            $table->foreign('budget_id')->references('budget_id')->on('budgets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proposals');
    }
}

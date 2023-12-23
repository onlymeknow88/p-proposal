<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRemoveToFormNopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('form_nops', function (Blueprint $table) {
            $table->dropColumn(['prep_by','rev_by','appr_by']);

            $table->integer('amount')->nullable();
            $table->unsignedInteger('prop_id')->nullable();

            $table->foreign('prop_id')->references('prop_id')->on('proposals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('form_nops', function (Blueprint $table) {
            $table->dropColumn(['amount','prop_id']);
        });
    }
}

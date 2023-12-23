<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->string('appr_deptHead')->nullable();
            $table->string('sts_appr_deptHead')->nullable();
            $table->date('appr_deptHead_date')->nullable();
            $table->longText('note_deptHead')->nullable();
            $table->string('appr_divHead')->nullable();
            $table->string('sts_appr_divHead')->nullable();
            $table->date('appr_divHead_date')->nullable();
            $table->longText('note_divHead')->nullable();
            $table->string('appr_director')->nullable();
            $table->string('sts_appr_director')->nullable();
            $table->date('appr_director_date')->nullable();
            $table->longText('note_director')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropColumn(['appr_deptHead', 'sts_appr_deptHead', 'appr_deptHead_date', 'appr_divHead', 'sts_appr_divHead', 'appr_divHead_date', 'note_deptHead', 'note_divHead', 'appr_director', 'sts_appr_director', 'appr_director_date', 'note_director']);
        });
    }
}

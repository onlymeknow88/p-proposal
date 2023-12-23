<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUidToInboxApprsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inbox_apprs', function (Blueprint $table) {
            $table->unsignedInteger('uid')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inbox_apprs', function (Blueprint $table) {
            $table->dropColumn('uid');
        });
    }
}

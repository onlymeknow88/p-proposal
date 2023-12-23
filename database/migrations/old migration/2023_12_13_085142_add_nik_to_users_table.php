<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNikToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string("nik")->after("name");
            $table->string("role_id")->default(0)->after('email');
            $table->integer('is_dept_head')->nullable()->after('role_id');
            $table->integer('is_div_head')->nullable()->after('is_dept_head');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(["nik",'role_id','is_dept_head','is_div_head']);
        });
    }
}

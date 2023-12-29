<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeFieldsNullableTblEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_employees', function (Blueprint $table) {
            $table->integer('brgy_id2')->nullable()->change();
            $table->string('acct_no',20)->nullable()->change();
            $table->string('tin',20)->nullable()->change();
            $table->string('contact_no',20)->nullable()->change();
            $table->string('email',50)->nullable()->change();
            $table->integer('eligibility_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_employees', function (Blueprint $table) {
            $table->integer('brgy_id2')->change();
            $table->string('acct_no',20)->change();
            $table->string('tin',20)->change();
            $table->string('contact_no',20)->change();
            $table->string('email',50)->change();
            $table->integer('eligibility_id')->change();
        });
    }
}

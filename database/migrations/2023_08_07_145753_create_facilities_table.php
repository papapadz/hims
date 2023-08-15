<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('facility_name',150);
            $table->string('facility_code')->nullable();
            $table->bigInteger('address_id');
            $table->string('location',100)->nullable();
            $table->string('contact_num',50)->nullable();
            $table->string('website',50)->nullable();
            $table->string('email_address',50);
            $table->string('facility_type',50);
            $table->string('facility_classification',50);
            $table->string('licensing_status',50)->nullable();
            $table->integer('bed_capacity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facilities');
    }
}

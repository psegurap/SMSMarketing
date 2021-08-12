<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_address', function (Blueprint $table) {
            $table->id();
            $table->string('mail_street_address', 500)->nullable();
            $table->string('mail_city', 100)->nullable();
            $table->string('mail_state', 10)->nullable();
            $table->string('mail_zip_code', 100)->nullable();
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
        Schema::dropIfExists('mail_address');
    }
}

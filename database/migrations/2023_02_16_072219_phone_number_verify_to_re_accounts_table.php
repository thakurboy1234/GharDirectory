<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('re_accounts', function (Blueprint $table) {
            $table->integer('phone_otp')->nullable();
            $table->tinyInteger('phone_number_verify_via_admin')->default(0)->nullable();

        });

        Schema::create('phone_number_verify_otps', function (Blueprint $table) {
            $table->id();
            $table->integer('otp')->nullable();
            $table->integer('user_id')->nullable();
            $table->tinyInteger('status')->default(0)->nullable();
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
        Schema::table('re_accounts', function (Blueprint $table) {
            $table->dropColumn('phone_otp');
            $table->dropColumn('phone_number_verify_via_admin');
        });

        Schema::dropIfExists('phone_number_verify_otps');
    }
};

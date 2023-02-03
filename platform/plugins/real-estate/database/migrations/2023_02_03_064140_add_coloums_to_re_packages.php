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
        Schema::table('re_packages', function (Blueprint $table) {
            $table->integer('maximal_property_budget')->nullable();
            $table->integer('total_leads')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('gst')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('re_packages', function (Blueprint $table) {
            $table->dropColumn('maximal_property_budget');
            $table->dropColumn('total_leads');
            $table->dropColumn('duration');
            $table->dropColumn('gst');

        });
    }
};

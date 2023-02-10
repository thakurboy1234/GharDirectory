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
            $table->renameColumn('first_name', 'full_name');
            $table->renameColumn('last_name', 'company_name');
            $table->string('alternate_mobile_number')->nullable();
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
            $table->renameColumn('full_name','first_name');
            $table->renameColumn('company_name','last_name');
            $table->dropColumn('alternate_mobile_number');
        });
    }
};

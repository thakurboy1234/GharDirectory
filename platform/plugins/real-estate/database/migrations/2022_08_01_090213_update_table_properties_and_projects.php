<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('re_properties', function (Blueprint $table) {
            $table->integer('country_id')->unsigned()->default(1)->nullable();
            $table->integer('state_id')->unsigned()->nullable();
        });

        Schema::table('re_projects', function (Blueprint $table) {
            $table->integer('country_id')->unsigned()->default(1)->nullable();
            $table->integer('state_id')->unsigned()->nullable();
        });

        DB::statement(
            <<<'SQL'
                UPDATE re_properties INNER JOIN cities ON re_properties.city_id = cities.id
                SET re_properties.state_id = cities.state_id, re_properties.country_id = cities.country_id WHERE re_properties.city_id IS NOT NULL
            SQL
        );

        DB::statement(
            <<<'SQL'
                UPDATE re_projects INNER JOIN cities ON re_projects.city_id = cities.id
                SET re_projects.state_id = cities.state_id, re_projects.country_id = cities.country_id WHERE re_projects.city_id IS NOT NULL
            SQL
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};

<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersProfilesTableToChangeSponsoredAsDateColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_profiles', function (Blueprint $table) {
            $table->dropColumn('sponsored');
        });
        Schema::table('users_profiles', function (Blueprint $table) {
            $table->dateTimeTz('sponsored')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_profiles', function (Blueprint $table) {
            $table->dropColumn('sponsored');
        });
        Schema::table('users_profiles', function (Blueprint $table) {
            $table->boolean('sponsored')->default(false);
        });
    }
}

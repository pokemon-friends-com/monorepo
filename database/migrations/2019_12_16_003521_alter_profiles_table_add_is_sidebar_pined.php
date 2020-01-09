<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProfilesTableAddIsSidebarPined extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_profiles', function (Blueprint $table) {
            $table->boolean('is_sidebar_pined')->default(false)->after('maiden_name');
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
            $table->dropColumn('is_sidebar_pined');
        });
    }
}
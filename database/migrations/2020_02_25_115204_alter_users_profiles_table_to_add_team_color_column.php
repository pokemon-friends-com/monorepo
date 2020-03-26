<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use template\Domain\Users\Profiles\ProfilesTeamsColors;

class AlterUsersProfilesTableToAddTeamColorColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_profiles', function (Blueprint $table) {
            $table
                ->enum('team_color', ProfilesTeamsColors::COLORS)
                ->default(ProfilesTeamsColors::DEFAULT)
                ->index();
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
            $table->dropColumn('team_color');
        });
    }
}

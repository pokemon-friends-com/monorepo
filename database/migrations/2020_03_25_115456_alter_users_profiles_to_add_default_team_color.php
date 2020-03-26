<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use template\Domain\Users\Profiles\ProfilesTeamsColors;

class AlterUsersProfilesToAddDefaultTeamColor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ('sqlite' !== config('database.default')) {
            DB::statement('ALTER TABLE users_profiles CHANGE COLUMN team_color team_color ENUM("'.collect(ProfilesTeamsColors::COLORS)->implode('","').'")');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('add_default_team_color', function (Blueprint $table) {
            //
        });
    }
}

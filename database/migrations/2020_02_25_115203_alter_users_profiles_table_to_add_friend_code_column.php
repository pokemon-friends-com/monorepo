<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use template\Domain\Users\Profiles\ProfilesTeamsColors;

class AlterUsersProfilesTableToAddFriendCodeColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_profiles', function (Blueprint $table) {
            $table->string('friend_code', 12)->nullable(true)->comment('Code ami');
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
            $table->dropColumn('friend_code');
        });
    }
}

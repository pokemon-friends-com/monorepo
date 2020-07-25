<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use pkmnfriends\Infrastructure\Interfaces\Domain\Users\Users\UserCivilitiesInterface;
use pkmnfriends\Infrastructure\Interfaces\Domain\Users\Users\UserRolesInterface;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uniqid', 13)->unique()->index();
            $table
                ->enum('role', UserRolesInterface::ROLES)
                ->default(UserRolesInterface::ROLE_CUSTOMER)
                ->index();
            $table
                ->enum('civility', UserCivilitiesInterface::CIVILITIES)
                ->default(UserCivilitiesInterface::CIVILITY_MADAM)
                ->index();
            $table->string('first_name', 100)->nullable(true)->index();
            $table->string('last_name', 100)->nullable(true)->index();
            $table->string('email', 80)->unique()->index();
            $table->string('password', 100);
            $table->rememberToken();
            $table->timestampsTz();
            $table->softDeletesTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

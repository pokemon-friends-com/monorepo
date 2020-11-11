<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use pkmnfriends\Infrastructure\Interfaces\Domain\Users\Profiles\ProfileFamiliesSituationsInterface;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->date('birth_date')->nullable()->index();
            $table
                ->enum('family_situation', ProfileFamiliesSituationsInterface::FAMILY_SITUATIONS)
                ->default(ProfileFamiliesSituationsInterface::FAMILY_SITUATION_SINGLE)
                ->index();
            $table->string('maiden_name', 100)->nullable()->comment('Nom de jeune fille');
            $table->timestamps();
            $table->softDeletes();
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}

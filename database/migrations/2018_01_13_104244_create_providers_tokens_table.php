<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use pkmnfriends\Infrastructure\Interfaces\Domain\Users\ProvidersTokens\ProvidersInterface;

class CreateProvidersTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers_tokens', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable(false)->index();
            $table->enum('provider', ProvidersInterface::PROVIDERS)->nullable(false)->index();
            $table->string('provider_id')->nullable(false)->index();
            $table->text('provider_token')->nullable(false);
            $table->timestampsTz();
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('providers_tokens');
    }
}

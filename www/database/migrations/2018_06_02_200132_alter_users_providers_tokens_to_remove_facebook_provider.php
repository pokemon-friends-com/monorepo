<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use pkmnfriends\Infrastructure\Interfaces\Domain\Users\ProvidersTokens\ProvidersInterface;
use pkmnfriends\Domain\Users\ProvidersTokens\ProviderToken;

class AlterUsersProvidersTokensToRemoveFacebookProvider extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        ProviderToken::where('provider', 'facebook')
            ->each(function ($model) {
                $model->delete();
            });

        if ('sqlite' !== config('database.default')) {
            DB::statement('ALTER TABLE users_providers_tokens CHANGE COLUMN provider provider ENUM("'.ProvidersInterface::TWITTER.'", "'.ProvidersInterface::GOOGLE.'")');
        }
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
}

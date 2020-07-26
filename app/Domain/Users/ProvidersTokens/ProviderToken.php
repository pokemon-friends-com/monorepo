<?php

namespace pkmnfriends\Domain\Users\ProvidersTokens;

use pkmnfriends\Infrastructure\Interfaces\Domain\Users\ProvidersTokens\ProvidersInterface;
use pkmnfriends\Infrastructure\Contracts\{
    Model\ModelAbstract,
    Model\Notifiable,
    Model\IdentifiableTrait,
    Model\TimeStampsTz
};
use pkmnfriends\Domain\Users\Users\User;

class ProviderToken extends ModelAbstract implements ProvidersInterface
{
    use Notifiable;
    use IdentifiableTrait;
    use TimeStampsTz;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users_providers_tokens';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'provider',
        'provider_id',
        'provider_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * Get the user record associated with the provider_token.
     */
    public function user()
    {
        return $this
            ->belongsTo(User::class)
            ->withTrashed();
    }
}

<?php

namespace template\Domain\Users\Leads;

use template\Infrastructure\Contracts\
{
    Model\ModelAbstract,
    Model\Notifiable,
    Model\IdentifiableTrait,
    Model\TimeStampsTz,
    Model\SoftDeletesTz
};
use template\Domain\Users\Leads\Traits\HandshakeNotificationTrait;
use template\Infrastructure\Interfaces\Domain\Users\{
    Users\HandshakableInterface,
    Users\UserCivilitiesInterface,
    Users\UserGendersInterface
};
use template\Domain\Users\Users\
{
    User,
    Traits\NamableTrait,
    Traits\GenrableTrait
};

class Lead extends ModelAbstract implements
    UserCivilitiesInterface,
    UserGendersInterface,
    HandshakableInterface
{
    use Notifiable;
    use IdentifiableTrait;
    use HandshakeNotificationTrait;
    use NamableTrait;
    use GenrableTrait;
    use TimeStampsTz;
    use SoftDeletesTz;

    /**
     * @var string
     */
    protected $table = 'users_leads';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'civility',
        'first_name',
        'last_name',
        'email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * Get the user record associated with the lead.
     */
    public function user()
    {
        return $this
            ->belongsTo(User::class)
            ->withTrashed();
    }
}

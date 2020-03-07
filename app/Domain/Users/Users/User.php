<?php

namespace template\Domain\Users\Users;

use Lab404\Impersonate\Models\Impersonate;
use Laravel\Passport\HasApiTokens;
use template\Domain\Users\Profiles\Profile;
use template\Infrastructure\Interfaces\Domain\Users\{
    Users\HandshakableInterface,
    Users\UserCivilitiesInterface,
    Users\UserRolesInterface
};
use template\Infrastructure\Interfaces\Domain\{
    Locale\LocalesInterface,
    Locale\TimeZonesInterface
};
use template\Infrastructure\Contracts\{
    Model\AuthenticatableModelAbstract,
    Model\IdentifiableTrait,
    Model\Notifiable,
    Model\RouteKeyNameUniquidTrait,
    Model\SoftDeletes,
    Model\TimeStampsTz,
    Model\SoftDeletesTz
};
use template\Domain\Users\Leads\{
    Lead,
    Traits\HandshakeNotificationTrait
};
use template\Domain\Users\Profiles\Traits\ProfileableTrait;
use template\Domain\Users\ProvidersTokens\ProviderToken;
use template\Domain\Users\Users\
{
    Notifications\CreatedAccountByAdministrator,
    Notifications\ResetPassword,
    Traits\NamableTrait
};

class User extends AuthenticatableModelAbstract implements
    UserCivilitiesInterface,
    UserRolesInterface,
    LocalesInterface,
    TimeZonesInterface,
    HandshakableInterface
{
    use HasApiTokens;
    use Notifiable;
    use IdentifiableTrait;
    use SoftDeletes;
    use HandshakeNotificationTrait;
    use NamableTrait;
    use ProfileableTrait;
    use RouteKeyNameUniquidTrait;
    use TimeStampsTz;
    use SoftDeletesTz;
    use Impersonate;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uniqid',
        'locale',
        'timezone',
        'role',
        'civility',
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
    ];

    protected $with = [
        'profile',
    ];

    /**
     * Send the password reset notification.
     *
     * @param string $token
     *
     * @return $this
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));

        return $this;
    }

    /**
     * Send the created account notification for created account by
     * administrator.
     *
     * @return $this
     */
    public function sendCreatedAccountByAdministratorNotification()
    {
        $this->notify(new CreatedAccountByAdministrator($this));

        return $this;
    }

    /**
     * Is the user able to impersonated others users ?
     *
     * @return bool
     */
    public function canImpersonate()
    {
        return self::ROLE_ADMINISTRATOR === $this->role;
    }

    /**
     * Is the user able to be impersonated ?
     *
     * @return bool
     */
    public function canBeImpersonated()
    {
        return self::ROLE_ADMINISTRATOR !== $this->role;
    }

    /**
     * Is the user administrator ?
     *
     * @return bool
     */
    public function getIsAdministratorAttribute()
    {
        return self::ROLE_ADMINISTRATOR === $this->role;
    }

    /**
     * Is the user customer ?
     *
     * @return bool
     */
    public function getIsCustomerAttribute()
    {
        return self::ROLE_CUSTOMER === $this->role;
    }

    /**
     * Is the user accountant ?
     *
     * @return bool
     */
    public function getIsAccountantAttribute()
    {
        return self::ROLE_ACCOUNTANT === $this->role;
    }

    /**
     * Get the lead that owns the user.
     */
    public function lead()
    {
        return $this->hasOne(Lead::class);
    }

    /**
     * Get the profile that owns the user.
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * Get the providers with tokens that owns the user.
     */
    public function providers_tokens()
    {
        return $this->hasMany(ProviderToken::class);
    }
}

<?php

namespace pkmnfriends\Domain\Users\Users;

use Illuminate\Contracts\Translation\HasLocalePreference;
use Lab404\Impersonate\Models\Impersonate;
use Laravel\Passport\HasApiTokens;
use Yaquawa\Laravel\EmailReset\CanResetEmail;
use pkmnfriends\Domain\Users\Profiles\Profile;
use pkmnfriends\Infrastructure\Interfaces\Domain\Users\{
    Users\HandshakableInterface,
    Users\UserCivilitiesInterface,
    Users\UserGendersInterface,
    Users\UserRolesInterface
};
use pkmnfriends\Infrastructure\Interfaces\Domain\{
    Locale\LocalesInterface,
    Locale\TimeZonesInterface
};
use pkmnfriends\Infrastructure\Contracts\{Model\AuthenticatableModelAbstract,
    Model\IdentifiableTrait,
    Model\Notifiable,
    Model\RouteKeyNameUniquidTrait,
    Model\SoftDeletes,
    Model\TimeStampsTz,
    Model\SoftDeletesTz,
    Traits\SecurityHashTrait};
use pkmnfriends\Domain\Users\Profiles\Traits\ProfileableTrait;
use pkmnfriends\Domain\Users\ProvidersTokens\ProviderToken;
use pkmnfriends\Domain\Users\Users\{
    Notifications\CreatedAccountByAdministrator,
    Notifications\ResetPassword,
    Notifications\SponsoredFriendCode,
    Traits\NamableTrait,
    Traits\GenrableTrait
};

class User extends AuthenticatableModelAbstract implements
    UserCivilitiesInterface,
    UserGendersInterface,
    UserRolesInterface,
    LocalesInterface,
    TimeZonesInterface,
    HandshakableInterface,
    HasLocalePreference
{
    use HasApiTokens;
    use Notifiable;
    use IdentifiableTrait;
    use SoftDeletes;
    use NamableTrait;
    use GenrableTrait;
    use ProfileableTrait;
    use RouteKeyNameUniquidTrait;
    use TimeStampsTz;
    use SoftDeletesTz;
    use Impersonate;
    use CanResetEmail;
    use SecurityHashTrait;

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
        'created_at',
        'updated_at',
        'deleted_at',
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
     * Get the user's preferred locale.
     *
     * @return string
     */
    public function preferredLocale()
    {
        return $this->locale;
    }

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
     * Send the sponsored friend code to twitter..
     *
     * @return $this
     */
    public function sendSponsoredFriendCodeNotification()
    {
        $this->notify(new SponsoredFriendCode($this));

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


    public function validateStreamfeedTokenAttribute($token): bool
    {
        $data = $this->readHash($token);
        return $this->uniqid === $data['id'];
    }

    public function getStreamfeedTokenAttribute(): string
    {
        return $this->createHash(['id' => $this->uniqid]);
    }

    /**
     * {@inheritdoc}
     */
    public function getFullNameAttribute(): string
    {
        if (isset($this->profile->nickname)) {
            return $this->profile->nickname;
        }

        if (!$this->first_name && !$this->last_name) {
            return $this->email;
        }

        return trim(sprintf(
            '%s %s',
            ucfirst(strtolower($this->first_name)),
            ucfirst(strtolower($this->last_name))
        ));
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
    public function providersTokens()
    {
        return $this->hasMany(ProviderToken::class);
    }
}

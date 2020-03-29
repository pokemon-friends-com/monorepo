<?php

namespace template\Domain\Users\Profiles;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\
{
    HasMedia\HasMedia,
    HasMedia\HasMediaTrait
};
use template\Infrastructure\Interfaces\Domain\Users\Profiles\ProfileFamiliesSituationsInterface;
use template\Infrastructure\Contracts\
{
    Model\ModelAbstract,
    Model\TimeStampsTz,
    Model\SoftDeletesTz
};
use template\Domain\Users\
{
    Users\User
};
use template\Domain\Users\Profiles\ProfilesTeamsColors;

class Profile extends ModelAbstract implements ProfileFamiliesSituationsInterface, HasMedia, ProfilesTeamsColors
{
    use HasMediaTrait;
    use SoftDeletes;
    use TimeStampsTz;
    use SoftDeletesTz;

    /**
     * @var string
     */
    protected $table = 'users_profiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'birth_date',
        'family_situation',
        'maiden_name',
        'is_sidebar_pined',
        'friend_code',
        'team_color',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public static function claimableEmail(string $friendCode): string
    {
        return "{$friendCode}@pokemon-friends.com";
    }

    /**
     * Date mutator to obtain a variable "birth_date_carbon".
     *
     * @return Carbon
     * @throws \Exception
     */
    public function getBirthDateCarbonAttribute(): ?Carbon
    {
        return is_null($this->birth_date)
            ? null
            : new Carbon($this->birth_date);
    }

    /**
     * Claimable mutator.
     *
     * @return bool
     * @throws \Exception
     */
    public function getIsClaimableAttribute(): bool
    {
        return self::claimableEmail($this->friend_code) === $this->user->email;
    }

    /**
     * Formated friend_code mutator.
     *
     * @return string
     * @throws \Exception
     */
    public function getFormatedFriendCodeAttribute(): string
    {
        $firstPart = substr($this->friend_code, 0, 4);
        $secondPart = substr($this->friend_code, 4, 4);
        $thirdPart = substr($this->friend_code, 8, 4);

        return "{$firstPart}-{$secondPart}-{$thirdPart}";
    }

    /**
     * Get the user record associated with the trainer profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

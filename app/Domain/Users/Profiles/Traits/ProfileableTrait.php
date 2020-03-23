<?php namespace template\Domain\Users\Profiles\Traits;

use template\Domain\Users\Profiles\Repositories\ProfilesRepositoryEloquent;
use template\Domain\Users\
{
    Profiles\Profile
};

trait ProfileableTrait
{

    /**
     *
     */
    public static function bootProfileableTrait()
    {
        static::deleted(function ($entity) {
            $entity
                ->profile()
                ->get()
                ->each(function (Profile $profile) {
                    $profile->delete();
                });
        });
    }

    /**
     * Get the profile record associated with the user.
     *
     * @return mixed
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * @param array $parameters
     *
     * @return mixed
     */
    public function addProfile($parameters = [])
    {
        return app(ProfilesRepositoryEloquent::class)
            ->createUserProfile($this, $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return mixed
     */
    public function updateProfile($parameters = [])
    {
        return app(ProfilesRepositoryEloquent::class)
            ->updateUserProfile($this, $parameters);
    }

    /**
     * @return mixed
     */
    public function deleteProfile()
    {
        return app(ProfilesRepositoryEloquent::class)
            ->deleteUserProfile($this);
    }
}

<?php

namespace template\App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use template\Domain\Users\Profiles\ProfilesTeamsColors;
use template\Domain\Users\Profiles\Repositories\ProfilesRepositoryEloquent;
use template\Domain\Users\Users\Repositories\UsersRegistrationsRepositoryEloquent;

class RegisterFriendCodeJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @var mixed
     */
    protected $friendCode;

    /**
     * @var string
     */
    protected $teamColor;

    /**
     * RegisterFriendCodeJob constructor.
     *
     * @param string $friendCode
     * @param string $teamColor default ProfilesTeamsColors::BLUE
     */
    public function __construct(
        string $friendCode,
        string $teamColor = ProfilesTeamsColors::BLUE
    ) {
        $this->friendCode = filter_var($friendCode, FILTER_SANITIZE_NUMBER_INT);
        $this->teamColor = $teamColor;
    }

    /**
     * Execute the job.
     *
     * @param UsersRegistrationsRepositoryEloquent $r_users
     * @param ProfilesRepositoryEloquent $r_profiles
     */
    public function handle(
        UsersRegistrationsRepositoryEloquent $r_users,
        ProfilesRepositoryEloquent $r_profiles
    ) {
        try {
//            $r_profiles

            $user = $r_users
                ->registerUser(
                    "{$this->friendCode}@pokemon-friends.com",
                    bcrypt($this->friendCode)
                );

            $user->profile->friend_code = $this->friendCode;
            $user->profile->save();

        } catch (\Exception $exception) {
            app('sentry')->captureException($exception);
        }
    }
}

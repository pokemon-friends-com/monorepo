<?php

namespace template\Console\Commands;

use template\Domain\Files\Medias\Repositories\MediasRepositoryEloquent;
use template\Domain\Users\Profiles\Profile;
use template\Domain\Users\Profiles\Repositories\ProfilesRepositoryEloquent;
use template\Infrastructure\Contracts\Commands\CommandAbstract;

class GetQrCodeForFriendCodesCommand extends CommandAbstract
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'profiles:qrcode';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get profiles friends codes QR codes';

    /**
     * @var ProfilesRepositoryEloquent
     */
    protected $r_profiles;

    /**
     * @var MediasRepositoryEloquent
     */
    protected $r_medias;

    /**
     * GenerateSitemapCommand constructor.
     *
     * @param ProfilesRepositoryEloquent $r_profiles
     */
    public function __construct(
        ProfilesRepositoryEloquent $r_profiles,
        MediasRepositoryEloquent $r_medias
    ) {
        parent::__construct();

        $this->r_profiles = $r_profiles;
        $this->r_medias = $r_medias;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this
            ->r_profiles
            ->with(['user'])
            ->whereNotNull('friend_code')
            ->chunk(100, function ($profiles) {
                $profiles->each(function (Profile $profile) {
                    $collection = 'trainer';
                    $profile
                        ->clearMediaCollection($collection)
                        ->save();
                    $profile
                        ->addMediaFromUrl(
                            'https://api.qrserver.com/v1/create-qr-code/'
                            . "?size=300x300&format=png&data={$profile->friend_code}"
                        )
                        ->setName($profile->friend_code)
                        ->setFileName("{$profile->friend_code}.png")
                        ->toMediaCollection($collection);
                });
            });

        return 0;
    }
}

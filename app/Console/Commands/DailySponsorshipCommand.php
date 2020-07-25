<?php

namespace pkmnfriends\Console\Commands;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use pkmnfriends\Domain\Users\Profiles\Repositories\ProfilesRepositoryEloquent;
use pkmnfriends\Infrastructure\Contracts\Commands\CommandAbstract;

class DailySponsorshipCommand extends CommandAbstract
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'pkmn:daily-sponsor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Choose trainers for daily sponsorship.';

    /**
     * @var ProfilesRepositoryEloquent
     */
    protected $rProfiles;

    /**
     * GenerateSitemapCommand constructor.
     *
     * @param ProfilesRepositoryEloquent $rProfiles
     */
    public function __construct(ProfilesRepositoryEloquent $rProfiles)
    {
        parent::__construct();

        $this->rProfiles = $rProfiles;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this
            ->rProfiles
            ->scopeQuery(function (Builder $model) {
                // remove default `order by updated_at desc`
                $model->getQuery()->orders = null;
                return $model
                    ->whereNull('sponsored')
                    ->orWhereDate('sponsored', '<>', Carbon::yesterday()->format('Y-m-d'))
                    ->orderBy('updated_at', 'asc')
                    ->orderBy(DB::raw('-sponsored'), 'asc')
                    ->limit(96);
            })
            ->all()
            ->each(function ($model) {
                $model->sponsored = Carbon::now()->format('Y-m-d H:i:s');
                $model->save();
            });

        return 0;
    }
}

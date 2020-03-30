<?php

namespace checkCoverage\Console\Commands;

use checkCoverage\Infrastructure\Contracts\Commands\CommandAbstract;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CheckCoverageCommand extends CommandAbstract
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'test:check-coverage
     {file : The clover.xml file path}
     {coverage : The coverage percentage expected}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify coverage percentage.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $totalElements = 0;
        $checkedElements = 0;
        $localFile = $this->argument('file');
        $percentage = (int) $this->argument('coverage');

        $validator = Validator::make([
            'coverage' => $percentage,
        ], [
            'coverage' => 'required|digits_between:0,100',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            foreach ($errors->get('email') as $message) {
                $this->error($message);
            }

            return 1;
        }

        if (!File::exists($localFile)) {
            throw new FileNotFoundException("File does not exist.");
        }

        $metrics = (new \SimpleXMLElement(File::get($localFile)))->xpath('//metrics');

        foreach ($metrics as $metric) {
            $totalElements += (int) $metric['elements'];
            $checkedElements += (int) $metric['coveredelements'];
        }

        $coverage = round(($checkedElements / $totalElements) * 100, 2);

        if ($coverage < $percentage) {
            $this->error("Code coverage is {$coverage}%, which is below the accepted {$percentage}%");

            return 1;
        }

        $this->info("Code coverage is {$coverage}% - OK!");

        return 0;
    }
}

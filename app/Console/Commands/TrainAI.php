<?php

namespace App\Console\Commands;

use App\CreditCardDefaultClient;
use App\Education;
use App\MaritalStatus;
use App\RepaymentStatus;
use App\Sex;
use C45\C45;
use Exception;
use Illuminate\Console\Command;
use Laracsv\Export as LaracsvExport;
use Storage;

class TrainAI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ai:train';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Train AI and build the decision tree based on C4.5 Algorithm';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Please wait...');

        try {
            $now = now();

            $this->createCsvFile();

            $this->buildTree();

            $this->info('Done!');

            $minutes = $now->diffInMinutes(now());

            $this->info('Train time: '.$minutes.' '.str_plural('minute', $minutes));
        } catch (Exception $e) {
            $this->error('Something went wrong: '.$e->getMessage());
        }
    }

    protected function createCsvFile()
    {
        if (!ini_get('auto_detect_line_endings')) {
            ini_set('auto_detect_line_endings', '1');
        }

        $data = CreditCardDefaultClient::all();

        $csvExporter = new LaracsvExport;
        $csvExporter->getWriter()->setEnclosure("'");
        $csvExporter->beforeEach(function ($creditCardDefaultClient) {
            $creditCardDefaultClient->sex = str_replace(' ', '', Sex::get($creditCardDefaultClient->sex));
            $creditCardDefaultClient->education = str_replace(' ', '', Education::get($creditCardDefaultClient->education));
            $creditCardDefaultClient->marital_status = str_replace(' ', '', MaritalStatus::get($creditCardDefaultClient->marital_status));

            for ($i = 1; $i <= 6; $i++) {
                $code = $creditCardDefaultClient->{'pay_' . $i};

                if (RepaymentStatus::isDuly($code)) {
                    $creditCardDefaultClient->{'pay_' . $i} = 'Duly';
                } else {
                    $num = abs($code);

                    $creditCardDefaultClient->{'pay_' . $i} = str_replace(' ', '', 'Late ' . $num . ' ' . str_plural('Month', $num));
                }
            }

            $creditCardDefaultClient->is_next_month_default_name = $creditCardDefaultClient->is_next_month_default ? 'true' : 'false';

            $creditCardDefaultClient->is_retired = $creditCardDefaultClient->age >= 65 ? 'true' : 'false';
        });

        $fields = [
            'sex' => '"sex"',
            'education' => '"education"',
            'marital_status' => '"marital_status"',
            'is_retired' => '"is_retired"',
        ];

        for ($i = 1; $i <= 6; $i++) {
            $fields['pay_' . $i] = '"pay_' . $i . '"';
        }

        $fields['is_next_month_default_name'] = '"is_next_month_default"';

        Storage::disk('local')->put('dataset.csv', $csvExporter->build($data, $fields)->getWriter()->getContent());
    }

    protected function buildTree()
    {
        $c45 = new C45([
            'targetAttribute' => 'is_next_month_default',
            'trainingFile' => storage_path('app/dataset.csv'),
            'splitCriterion' => C45::SPLIT_GAIN,
        ]);

        $tree = $c45->buildTree();

        $tree->saveToFile(storage_path('app/tree'));
    }
}

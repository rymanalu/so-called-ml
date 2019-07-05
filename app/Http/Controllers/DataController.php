<?php

namespace App\Http\Controllers;

use App\CreditCardDefaultClient;
use App\Education;
use App\MaritalStatus;
use App\RepaymentStatus;
use App\Sex;
use DataTables;
use Laracsv\Export as LaracsvExport;
use Storage;

class DataController extends Controller
{
    public function index()
    {
        return view('data.index');
    }

    public function datatables()
    {
        ini_set('memory_limit', '1G');

        $dataTables = DataTables::of(CreditCardDefaultClient::query())
            ->addColumn('sex_name', function (CreditCardDefaultClient $creditCardDefaultClient) {
                return Sex::get($creditCardDefaultClient->sex);
            })
            ->addColumn('education_name', function (CreditCardDefaultClient $creditCardDefaultClient) {
                return Education::get(($creditCardDefaultClient->education));
            })
            ->addColumn('marital_status_name', function (CreditCardDefaultClient $creditCardDefaultClient) {
                return MaritalStatus::get($creditCardDefaultClient->marital_status);
            })
            ->addColumn('is_next_month_default_name', function (CreditCardDefaultClient $creditCardDefaultClient) {
                return $creditCardDefaultClient->is_next_month_default ? 'Yes' : 'No';
            })
            ->addColumn('limit_balance_ntd', function (CreditCardDefaultClient $creditCardDefaultClient) {
                return number_format($creditCardDefaultClient->limit_balance);
            });

        for ($i = 1; $i <= 6; $i++) {
            $dataTables = $dataTables->addColumn('pay_' . $i . '_name', function (CreditCardDefaultClient $creditCardDefaultClient) use ($i) {
                $code = $creditCardDefaultClient->{'pay_' . $i};

                if (RepaymentStatus::isDuly($code)) {
                    return 'Duly';
                }

                $num = abs($code);

                return 'Late ' . $num . ' ' . str_plural('Month', $num);
            });
        }

        return $dataTables->toJson();
    }

    public function train()
    {
        if (! ini_get('auto_detect_line_endings')) {
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

            $creditCardDefaultClient->is_next_month_default_name = ($creditCardDefaultClient->is_next_month_default ? 'true' : 'false');
        });

        $fields = [
            'sex' => '"sex"',
            'education' => '"education"',
            'marital_status' => '"marital_status"',
            'age' => '"age"',
        ];

        for ($i = 1; $i <= 6; $i++) {
            $fields['pay_' . $i] = '"pay_'.$i.'"';
        }

        $fields['is_next_month_default_name'] = '"is_next_month_default"';

        Storage::disk('local')->put('dataset.csv', $csvExporter->build($data, $fields)->getWriter()->getContent());

        return redirect()->route('data:index');
    }
}

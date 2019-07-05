<?php

namespace App\Http\Controllers;

use App\CreditCardDefaultClient;
use App\Education;
use App\MaritalStatus;
use App\RepaymentStatus;
use App\Sex;
use DataTables;
use Illuminate\Http\Request;

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
}

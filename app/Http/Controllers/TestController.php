<?php

namespace App\Http\Controllers;

use App\Education;
use App\Http\Requests\TestRequest;
use App\MaritalStatus;
use App\RepaymentStatus;
use App\Sex;
use C45\TreeNode;
use Illuminate\Http\Request;
use Storage;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $sexes = Sex::all();
        $educations = Education::all();
        $maritalStatuses = MaritalStatus::all();

        return view('test.index', compact('sexes', 'educations', 'maritalStatuses', 'request'));
    }

    public function test(TestRequest $request)
    {
        if (Storage::disk('local')->exists('tree')) {
            $tree = TreeNode::createFromFile(storage_path('app/tree'));

            $data = [
                'sex' => Sex::get($request->sex),
                'education' => str_replace(' ', '', Education::get($request->education)),
                'marital_status' => str_replace(' ', '', MaritalStatus::get($request->marital_status)),
                'is_retired' => $request->age >= 65 ? 'true' : 'false',
            ];

            for ($i = 1; $i <= 6; $i++) {
                $num = $request->input('payment_'.$i.'_late');

                $data['pay_'.$i] = RepaymentStatus::isDuly(-$num) ? 'Duly' : str_replace(' ', '', 'Late ' . $num . ' ' . str_plural('Month', $num));
            }

            $result = $tree->classify($data);

            flash('Is this person\'s payment will be late in the next month: '.($result == 'true' ? 'YES' : 'NO'))->success();
        } else {
            flash('AI haven\'t trained! Please run "php artisan ai:train" first.')->warning();
        }

        return $this->index($request);
    }
}

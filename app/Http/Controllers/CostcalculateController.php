<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App;
use Carbon\Carbon;


class CostcalculateController extends Controller
{
    public function index()
    {
        return view('cost_calculator');
    }

    public function costCalculate(Request $request)
    {
        $user_inputs           = $request->except('_token');
        $arr_of_items          = [];
        $total_cost_of_project = 0;
        $imagename             = null;
        $vat                   = $user_inputs['vat'] == null ? 0 : $user_inputs['vat'];

        foreach ($user_inputs as $key => $value) {
            if (gettype($value) == 'array') {
                array_push($arr_of_items, $value);
            }
        }

        $total_cost = $this->sumOfCost($request);
        if (count($arr_of_items) > 0) {
            $sum = 0;
            foreach ($arr_of_items as $items) {
                $sum += $items[1];
            }
            $total_cost_of_project = $total_cost + $sum;
            $total_cost_of_project = $this->calculateVatWithCost($total_cost_of_project, $vat);
        } else {
            $total_cost_of_project = $total_cost;
            $total_cost_of_project = $this->calculateVatWithCost($total_cost_of_project, $vat);
        }


        if ($request->hasFile('image')) {
            $imagename = $this->imageUpload($request);
        }


        $data = $this->makeArrOfData($user_inputs, $total_cost_of_project, $arr_of_items, $imagename);
        $pdf  = App::make('dompdf.wrapper');
        $pdf  = Pdf::loadView('pdf_result', $data);
        return $pdf->stream();
    }

    protected function sumOfCost($request)
    {
        $total_cost = 0;

        $frontend_dev      = $request->frontend_dev ? $request->frontend_dev : 0;
        $frontend_dev_cost = $request->frontend_dev_cost ? $request->frontend_dev_cost : 0;

        $backend_dev      = $request->backend_dev ? $request->backend_dev : 0;
        $backend_dev_cost = $request->backend_dev_cost ? $request->backend_dev_cost : 0;

        $mobile_app_dev      = $request->mobile_app_dev ? $request->mobile_app_dev : 0;
        $mobile_app_dev_cost = $request->mobile_app_dev_cost ? $request->mobile_app_dev_cost : 0;

        $total_hour_of_work = $request->total_hour ? $request->total_hour : 0;
        $cost_per_hour      = $request->cost_per_hour ? $request->cost_per_hour : 0;

        $server_cost = $request->server_cost ? $request->server_cost : 0;
        $domain_cost = $request->domain_cost ? $request->domain_cost : 0;

        $total_cost = $frontend_dev * $frontend_dev_cost + $backend_dev * $backend_dev_cost + $mobile_app_dev * $mobile_app_dev_cost + $total_hour_of_work * $cost_per_hour + $server_cost + $domain_cost;

        return $total_cost;
    }

    protected function makeArrOfData($user_inputs, $total_cost_of_project, $arr_of_items, $imagename)
    {
        $data = [];

        $data = [
            'frontend_dev'          => $user_inputs['frontend_dev'] ? $user_inputs['frontend_dev'] : null,
            'frontend_dev_cost'     => $user_inputs['frontend_dev_cost'] ? $user_inputs['frontend_dev_cost'] : null,
            'backend_dev'           => $user_inputs['backend_dev'] ? $user_inputs['backend_dev'] : null,
            'backend_dev_cost'      => $user_inputs['backend_dev_cost'] ? $user_inputs['backend_dev_cost'] : null,
            'mobile_app_dev'        => $user_inputs['mobile_app_dev'] ? $user_inputs['mobile_app_dev'] : null,
            'mobile_app_dev_cost'   => $user_inputs['mobile_app_dev_cost'] ? $user_inputs['mobile_app_dev_cost'] : null,
            'total_hour_of_work'    => $user_inputs['total_hour'] ? $user_inputs['total_hour'] : null,
            'cost_per_hour'         => $user_inputs['cost_per_hour'] ? $user_inputs['cost_per_hour'] : null,
            'server_cost'           => $user_inputs['server_cost'] ? $user_inputs['server_cost'] : null,
            'domain_cost'           => $user_inputs['domain_cost'] ? $user_inputs['domain_cost'] : null,
            'total_cost_of_project' => $total_cost_of_project,
            'company_address'       => $user_inputs['company_address'] ? $user_inputs['company_address'] : null,
            'client_name'           => $user_inputs['client_name'] ? $user_inputs['client_name'] : null,
            'client_address'        => $user_inputs['client_address'] ? $user_inputs['client_address'] : null,
            'arr_of_items'          => $arr_of_items,
            'imagename'             => $imagename,
            'vat'                   => $user_inputs['vat'] ? $user_inputs['vat'] : null,
        ];

        return $data;
    }

    protected function imageUpload($request)
    {
        $imagename     = null;
        $request_image = $request->file('image');
        if (isset($request_image)) {
            $currentDate = Carbon::now()->toDateString();
            $imagename   = $currentDate . '-' . uniqid() . '.' . $request_image->getClientOriginalExtension();
            if (!file_exists('uploads/images')) {
                mkdir('uploads/images', 0777, true);
            }
            $request_image->move('uploads/images', $imagename);
        }
        return $imagename;
    }

    protected function calculateVatWithCost($cost, $vat)
    {
        $tex = $vat / 100;
        return $cost + $cost * $tex;
    }
}

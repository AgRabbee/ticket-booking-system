<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index()
    {
        $dashDetails = new User();
        $data = [
            'userCount'     => $dashDetails->count_company_users(),
            'companyCount'  => $dashDetails->companyCount(),
            'customerCount' => $dashDetails->customers(),
            'tripsCount'    => $dashDetails->tripsCount(),
        ];

        return view('admin.adminHome')->with($data);
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View|void
     */
    public function companyAdmin()
    {
        if (Auth::user()->companies[0]->pivot->status == 1) {
            $dashDetails = new Company();
            $data = [
                'userCount'         => $dashDetails->userCount(),
                'transportCount'    => $dashDetails->transportCount(),
                'tripsCount'        => $dashDetails->tripsCount(),
                'reservationsCount' => $dashDetails->reservationsCount(),
            ];

            return view('company_admin.home')->with($data);

        } elseif (Auth::user()->companies[0]->pivot->status == 0) {
            return redirect('/')->withInfoMessage('Your registration request is not accepted yet. Contact with System Admin.');
        } elseif (Auth::user()->companies[0]->pivot->status == 2) {
            return redirect('/')->withInfoMessage('Your registration request is Denied. Contact with System Admin.');
        }
    }
}

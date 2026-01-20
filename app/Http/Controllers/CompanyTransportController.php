<?php

namespace App\Http\Controllers;

use App\Models\CompanyTransport;
use App\Models\Transport;
use Auth;
use Illuminate\Http\Request;

class CompanyTransportController extends Controller
{

    public function create()
    {
        return view('company_admin.add_transport')->with('transport_types', Transport::orderBy('transport_type', 'Asc')->get());
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'transport_type'  => 'required|integer',
            'total_seats'     => 'required|regex:/^[1-9][0-9]+/|not_in:0',
            'registration_no' => 'required|string|unique:company_transport',
        ]);

        $companyTransport = new CompanyTransport;
        $companyTransport->company_id = Auth::user()->companies[0]->id;
        $companyTransport->transport_type_id = $request['transport_type'];
        $companyTransport->total_seats = $request['total_seats'];
        $companyTransport->registration_no = $request['registration_no'];
        $companyTransport->save();

        return redirect()->back()->withSuccessMessage('Transport Added Successfully');

    }

    public function allBuses()
    {
        $bus_details = CompanyTransport::where('company_id', Auth::user()->companies[0]->id)->get();
        return view('company_admin.all_buses')->with('bus_details', $bus_details);
    }

}

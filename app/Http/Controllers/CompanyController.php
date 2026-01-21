<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\Company;
use App\Models\Reservation;
use App\Models\Role;
use App\Models\Trip;
use App\Models\User;
use Auth;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CompanyController extends Controller
{
    public function index()
    {
        $c_admins = DB::table('company_user')
            ->join('users', 'users.id', '=', 'company_user.user_id')
            ->join('companies', 'companies.id', '=', 'company_user.company_id')
            ->join('role_user', function ($join) {
                $join->on('role_user.user_id', '=', 'users.id')
                    ->where('role_user.role_id', 2);
            })
            ->select([
                'users.id as user_id',
                'users.first_name',
                'users.last_name',
                'users.email',
                'companies.id as company_id',
                'companies.company_name',
                'companies.description',
                'companies.address',
                'companies.reg_no',
                'companies.tin_no',
                'companies.company_image',
                'companies.trade',
                'companies.vat',
                'company_user.status',
            ])
            ->get();

        return view('admin.company_admin', [ 'admin_details' => $c_admins ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (!Auth::user()->companies->count()) {

            // return view('company.index');
        } else {
            return redirect('/company/dashboard');
        }

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'company_name'        => 'required|string',
            'company_description' => 'required|string',
            'address'             => 'required|string',
            'reg_no'              => 'required|string',
            'tin_no'              => 'required|integer',
            'company_image'       => 'image|nullable|max:1999',
            'trade'               => 'required|image|max:1999',
            'vat'                 => 'required|image|max:1999',
        ]);

        //handle company_image upload
        if ($request->hasFile('company_image')) {
            //get filename with the extension
            $fileNamewithExt = $request->file('company_image')->getClientOriginalName();
            //get just filename
            $fileName = pathinfo($fileNamewithExt, PATHINFO_FILENAME);
            //get just ext
            $extension = $request->file('company_image')->getClientOriginalExtension();
            //file name to store
            $fileNameToStore = $fileName . '_' . time() . '_.' . $extension;
            //upload image
            $path = $request->file('company_image')->storeAs('public/company_image', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        //handle trade_image upload
        if ($request->hasFile('trade')) {
            //get filename with the extension
            $fileNamewithExt = $request->file('trade')->getClientOriginalName();
            //get just filename
            $fileName = pathinfo($fileNamewithExt, PATHINFO_FILENAME);
            //get just ext
            $extension = $request->file('trade')->getClientOriginalExtension();
            //file name to store
            $fileName1ToStore = $fileName . '_' . time() . '_.' . $extension;
            //upload image
            $path = $request->file('trade')->storeAs('public/company_image', $fileName1ToStore);
        }

        //handle vat_image upload
        if ($request->hasFile('vat')) {
            //get filename with the extension
            $fileNamewithExt = $request->file('vat')->getClientOriginalName();
            //get just filename
            $fileName = pathinfo($fileNamewithExt, PATHINFO_FILENAME);
            //get just ext
            $extension = $request->file('vat')->getClientOriginalExtension();
            //file name to store
            $fileName2ToStore = $fileName . '_' . time() . '_.' . $extension;
            //upload image
            $path = $request->file('vat')->storeAs('public/company_image', $fileName2ToStore);
        }

        $company = new Company;
        $company->company_name = $request['company_name'];
        $company->description = $request['company_description'];
        $company->address = $request['address'];
        $company->reg_no = $request['reg_no'];
        $company->tin_no = $request['tin_no'];
        $company->company_image = $fileNameToStore;
        $company->trade = $fileName1ToStore;
        $company->vat = $fileName2ToStore;
        $company->fees = 21;
        $company->company_status = 0;
        $company->save();

        $user_id = Auth::user()->id;
        $company->users()->attach($user_id, [ 'status' => 0 ]);

        //return redirect('/dashboard')->with('success','company created successfully');
        return redirect('/')->withSuccessMessage('Request for Company Registration Submitted Successfully');
    }

    public function updateStatus(Request $request, $status)
    {
        $statusEnum = Status::fromRoute($status);

        if (!$statusEnum) {
            abort(404, 'Invalid status');
        }

        try {
            $company = Company::with('users')->findOrFail($request->company_id);

            // Update pivot status
            $company->users->first()?->pivot->update([
                'status' => $statusEnum->value,
            ]);

            // Update company status
            $company->update([
                'company_status' => $statusEnum->value,
            ]);

            $adminRole = Role::where('name', 'Admin')->first();
            $admin = User::find($request->user_id);

            if ($admin && $adminRole) {
                match ($statusEnum) {
                    Status::ACTIVE =>
                    $admin->roles()->syncWithoutDetaching([ $adminRole->id ]),

                    Status::DENIED =>
                    $admin->roles()->detach($adminRole->id),

                    default        => null,
                };
            }

            return redirect('/dashboard/admins')->withSuccessMessage('Successfully ' . $status);
        } catch (Exception $e) {
            Log::error('Failed to update company status', [
                'status'     => $status,
                'company_id' => $request->company_id,
                'user_id'    => $request->user_id,
                'error'      => $e->getMessage(),
            ]);

            return redirect()->back()->withErrors([ 'error' => 'Unable to update status. Please try again.' ]);
        }
    }

    public function company_admin_panel()
    {
        if (Auth::user()->companies[0]->pivot->status == 1) {
            return view('company_admin.home');
        } elseif (Auth::user()->companies[0]->pivot->status == 0) {
            return redirect('/home')->withInfoMessage('Your registration request is not accepted yet. Contact with System Admin.');
        } elseif (Auth::user()->companies[0]->pivot->status == 2) {
            return redirect('/home')->withInfoMessage('Your registration request is Denied. Contact with System Admin.');
        }

    }

    public function allDrivers()
    {
        $company_id = Auth::user()->companies[0]->id;
        $driver_details = new Company;

        return view('company_admin.all_drivers')->with('driver_details', $driver_details->allDrivers($company_id));
    }

    public function addDriverForm()
    {
        return view('company_admin.addDriver');
    }

    public function addDriver(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            // 'email' => 'required|string',
            'phone'      => 'required|string',
            'password'   => 'required|string|min:6|confirmed',
            'nid'        => 'required|integer|max:99999999999',
            'terms'      => 'required',
        ]);

        $driver = new User;
        $driver->first_name = $request['first_name'];
        $driver->last_name = $request['last_name'];
        $driver->email = $request['email'];
        $driver->phone = $request['phone'];
        $driver->password = bcrypt($request['password']);
        $driver->nid = $request['nid'];
        $driver->user_status = 1;
        $driver->save();
        $driver->roles()->attach(Role::where('name', 'Driver')->first());

        $driver_id = $driver->id;
        $company_id = Auth::user()->companies[0]->id;
        $driver->companies()->attach($company_id, [ 'status' => 1 ]);

        return redirect()->back()->withSuccessMessage('Driver profile added successfully');
    }


    public function allSales()
    {
        $company_id = Auth::user()->companies[0]->id;
        $salesDetails = new Reservation();

        return view('company_admin.all_sales')->with('salesDetails', $salesDetails->allSales($company_id));
    }

    public function salesReports()
    {
        $company_id = Auth::user()->companies[0]->id;

        $reportData = DB::table('reservations')
            ->selectRaw('count(reservations.id) total, MONTHNAME(reservations.updated_at) month')
            ->join('trips', 'reservations.trip_id', 'trips.id')
            ->where('reservations.seat_status', '2')
            ->where('company_id', $company_id)
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->get();

        $trips = new Trip();
        $allTrips = $trips->allTrips($company_id);
        $data = [
            'reportData' => $reportData,
            'allTrips'   => $allTrips,
        ];

        // return view('company_admin.sales_report')->with('reportData',$reportData);
        return view('company_admin.sales_report')->with($data);
    }

    public function allSalesReports()
    {
        $reportData = DB::table('reservations')
            ->selectRaw('count(id) total, MONTHNAME(updated_at) month')
            ->where('seat_status', '2')
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->get();

        return view('admin.admin_report')->with('reportData', $reportData);
    }
}

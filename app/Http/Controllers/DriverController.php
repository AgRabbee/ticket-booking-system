<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddDriverRequest;
use App\Models\Company;
use App\Services\DriverService;
use Illuminate\Support\Facades\Log;
use Throwable;

class DriverController extends Controller
{
    public function __construct(private readonly DriverService $driverService)
    {
        parent::__construct();
    }

    public function index()
    {
        $companyId = auth()->user()->companies[0]->id;

        return view('company_admin.all_drivers', [
            'driver_details' => (new Company())->allDrivers($companyId),
        ]);
    }

    public function create()
    {
        return view('company_admin.addDriver');
    }

    public function store(AddDriverRequest $request)
    {
        try {
            $companyId = auth()->user()->companies[0]->id;
            $this->driverService->createDriver($request->validated(), $companyId);

            return redirect('/company/dashboard/all/drivers')->withSuccessMessage('Driver profile added successfully');
        } catch (Throwable $e) {
            Log::error('Add driver failed', [ 'error' => $e->getMessage() ]);

            return back()->withErrors('Unable to add driver');
        }
    }

}

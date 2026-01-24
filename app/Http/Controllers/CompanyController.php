<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Http\Requests\StoreCompanyRequest;
use App\Services\CompanyService;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class CompanyController extends Controller
{
    public function __construct(private readonly CompanyService $companyService)
    {
        parent::__construct();
    }

    public function index()
    {
        return view('admin.company_admin', [
            'admin_details' => $this->companyService->listCompanyAdmins(),
        ]);
    }

    public function create()
    {
        if (!Auth::user()->companies->count()) {
            return redirect()->back()->withErrors([ 'error' => 'You need to register company first!' ]);
        }

        return redirect('/company/dashboard');
    }

    /**
     * @throws Throwable
     */
    public function store(StoreCompanyRequest $request)
    {
        DB::beginTransaction();

        try {
            $this->companyService->storeCompany(
                $request->validated(),
                Auth::id()
            );

            DB::commit();

            return redirect('/')->withSuccessMessage('Request for Company Registration Submitted Successfully');

        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Company creation failed', [
                'error'   => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);

            return back()
                ->withErrors('Something went wrong. Please try again.')
                ->withInput();
        }
    }

    public function updateStatus(Request $request, string $status)
    {
        $statusEnum = Status::fromRoute($status);

        if (!$statusEnum) {
            abort(404, 'Invalid status');
        }

        try {
            $this->companyService->updateCompanyStatus(
                companyId: (int)$request->company_id,
                userId: (int)$request->user_id,
                status: $statusEnum
            );

            return redirect('/dashboard/admins')->withSuccessMessage("Successfully {$status}");

        } catch (Throwable $e) {
            Log::error('Failed to update company status', [
                'status'     => $status,
                'company_id' => $request->company_id,
                'user_id'    => $request->user_id,
                'error'      => $e->getMessage(),
            ]);

            return back()->withErrors([
                'error' => 'Unable to update status. Please try again.',
            ]);
        }
    }
}

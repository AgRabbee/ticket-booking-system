<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Services\CompanyAdminService;

class ReportController extends Controller
{

    public function __construct(private readonly CompanyAdminService $companyAdminService)
    {
        parent::__construct();
    }

    public function allSales()
    {
        $companyId = auth()->user()->companies[0]->id;

        return view('company_admin.all_sales', [
            'salesDetails' => (new Reservation())->allSales($companyId),
        ]);
    }

    public function salesReports()
    {
        $companyId = auth()->user()->companies[0]->id;

        return view(
            'company_admin.sales_report',
            $this->companyAdminService->salesReport($companyId)
        );
    }

    public function allSalesReports()
    {
        return view('admin.admin_report', [
            'reportData' => $this->companyAdminService->allSalesReport(),
        ]);
    }
}

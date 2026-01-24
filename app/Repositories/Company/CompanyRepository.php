<?php

namespace App\Repositories\Company;

use App\Enums\Status;
use App\Models\Company;
use DB;

class CompanyRepository implements CompanyRepositoryInterface
{
    public function getCompanyAdmins()
    {
        return DB::table('company_user')
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
    }

    public function create(array $data): Company
    {
        return Company::create($data);
    }

    public function findWithUsers(int $companyId): Company
    {
        /** @var Company */
        return Company::with('users')->findOrFail($companyId);
    }

    public function updateStatus(Company $company, int $status): void
    {
        $company->update([
            'company_status' => $status,
        ]);
    }

    public function attachUser(Company $company, int $userId): void
    {
        $company->users()->attach($userId, [ 'status' => Status::PENDING->value ]);
    }
}


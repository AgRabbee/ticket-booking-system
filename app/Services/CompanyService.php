<?php

namespace App\Services;

use App\Enums\Status;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use App\Repositories\Company\CompanyRepositoryInterface;
use Auth;
use Illuminate\Support\Facades\DB;

class CompanyService
{
    public function __construct(
        private readonly CompanyRepositoryInterface $companyRepository,
        private readonly FileService                $fileService
    )
    {
    }

    public function listCompanyAdmins()
    {
        return $this->companyRepository->getCompanyAdmins();
    }

    public function updateCompanyStatus(
        int    $companyId,
        int    $userId,
        Status $status
    ): void
    {
        DB::transaction(function () use ($companyId, $userId, $status) {

            $company = $this->companyRepository->findWithUsers($companyId);

            // Update pivot
            $company->users->first()?->pivot->update([
                'status' => $status->value,
            ]);

            // Update company
            $this->companyRepository->updateStatus($company, $status->value);

            // Sync admin role
            $this->syncAdminRole($userId, $status);
        });
    }

    private function syncAdminRole(int $userId, Status $status): void
    {
        $adminRole = Role::where('name', 'Admin')->first();
        $user = User::find($userId);

        if (!$user || !$adminRole) {
            return;
        }

        match ($status) {
            Status::ACTIVE => $user->roles()->syncWithoutDetaching([ $adminRole->id ]),
            Status::DENIED => $user->roles()->detach($adminRole->id),
            default        => null,
        };
    }

    public function storeCompany(array $data, int $userId): Company
    {
        $data['company_image'] = $this->fileService->upload(
            $data['company_image'] ?? null,
            'company_image'
        );

        $data['trade'] = $this->fileService->upload(
            $data['trade'],
            'company_image'
        );

        $data['vat'] = $this->fileService->upload(
            $data['vat'],
            'company_image'
        );

        $data['fees'] = 21;
        $data['company_status'] = 0;

        $company = $this->companyRepository->create($data);
        $this->companyRepository->attachUser($company, $userId);

        return $company;
    }
}

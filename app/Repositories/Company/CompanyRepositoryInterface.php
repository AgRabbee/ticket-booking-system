<?php

namespace App\Repositories\Company;

use App\Models\Company;

interface CompanyRepositoryInterface
{
    public function getCompanyAdmins();

    public function create(array $data): Company;

    public function findWithUsers(int $companyId): Company;

    public function updateStatus(Company $company, int $status): void;
}

<?php

namespace App\Services;

use App\Repositories\Reservation\ReservationRepository;
use App\Repositories\Trip\TripRepository;
use Illuminate\Support\Collection;

class CompanyAdminService
{
    public function __construct(
        private readonly ReservationRepository $reservationRepository,
        private readonly TripRepository        $tripRepository
    )
    {
    }

    public function salesReport(int $companyId): array
    {
        return [
            'reportData' => $this->reservationRepository->getCompanySales($companyId),
            'allTrips'   => $this->tripRepository->allTrips($companyId),
        ];
    }

    public function allSalesReport(): Collection
    {
        return $this->reservationRepository->getAllSales();
    }
}


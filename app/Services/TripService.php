<?php

namespace App\Services;

use App\Repositories\Trip\TripRepository;
use Illuminate\Support\Collection;

class TripService
{
    public function __construct(private readonly TripRepository $tripRepo)
    {
    }

    public function search($from, $to, $date): Collection
    {
        return $this->tripRepo->searchTrips($from, $to, $date);
    }

    public function allTripsForSuperAdmin(): Collection
    {
        return $this->tripRepo->allTripsForSuperAdmin();
    }

    public function allTrips(int $companyId): Collection
    {
        return $this->tripRepo->allTrips($companyId);
    }

    public function allLocations(): Collection
    {
        return $this->tripRepo->allLocations();
    }

    public function allRoutes(): Collection
    {
        return $this->tripRepo->allRoutes();
    }

    public function tripDetails(int $tripId): Collection
    {
        return $this->tripRepo->tripDetails($tripId);
    }

    public function allBuses(): Collection
    {
        return $this->tripRepo->allBuses();
    }

    public function allDrivers(): Collection
    {
        return $this->tripRepo->allDrivers();
    }
}

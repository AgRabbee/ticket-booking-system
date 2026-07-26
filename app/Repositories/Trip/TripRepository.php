<?php

namespace App\Repositories\Trip;

use App\Models\Trip;
use Illuminate\Support\Collection;

class TripRepository
{
    public function allTripsForSuperAdmin(): Collection
    {
        return (new Trip())->allTripsForSuperAdmin();
    }

    public function allTrips(int $companyId): Collection
    {
        return (new Trip())->allTrips($companyId);
    }

    public function allLocations(): Collection
    {
        return (new Trip())->allLocations();
    }

    public function allRoutes(): Collection
    {
        return (new Trip())->allRoutes();
    }

    public function searchTrips($from, $to, $date): Collection
    {
        return (new Trip())->searchTrips($from, $to, $date);
    }

    public function tripDetails(int $tripId): Collection
    {
        return (new Trip())->tripDetails($tripId);
    }

    public function allBuses(): Collection
    {
        return (new Trip())->allBuses();
    }

    public function allDrivers(): Collection
    {
        return (new Trip())->allDrivers();
    }
}


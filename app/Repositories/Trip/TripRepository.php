<?php

namespace App\Repositories\Trip;

use App\Models\Trip;
use Illuminate\Support\Collection;

class TripRepository
{
    public function allTrips(int $companyId): Collection
    {
        return (new Trip())->allTrips($companyId);
    }
}


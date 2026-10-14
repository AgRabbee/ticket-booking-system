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

    /**
     * Upcoming trips that still have at least one empty seat, soonest first.
     */
    public function bookableDepartures(): Collection
    {
        return $this->tripRepo->upcomingDepartures()
            ->filter(fn($trip) => $trip->seats_left > 0)
            ->sortBy(fn($trip) => $trip->date . ' ' . date('H:i', strtotime($trip->start_time)))
            ->values();
    }

    /**
     * One row per route, built from the bookable departures.
     */
    public function popularRoutes(Collection $departures): Collection
    {
        return $departures
            ->groupBy(fn($trip) => $trip->start_point . '-' . $trip->end_point)
            ->map(fn($trips) => (object)[
                'start_point' => $trips->first()->start_point,
                'end_point'   => $trips->first()->end_point,
                'start_name'  => $trips->first()->start_name,
                'end_name'    => $trips->first()->end_name,
                'min_fare'    => $trips->min('fare'),
                'next_date'   => $trips->first()->date,
                'departures'  => $trips->count(),
            ])
            ->sortByDesc('departures')
            ->values();
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

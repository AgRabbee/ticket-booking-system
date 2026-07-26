<?php

namespace App\Repositories\Reservation;

use App\Models\Reservation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ReservationRepository
{
    public function getCompanySales(int $companyId): Collection
    {
        return DB::table('reservations')
            ->join('trips', 'reservations.trip_id', 'trips.id')
            ->where('reservations.seat_status', '2')
            ->where('company_id', $companyId)
            ->selectRaw('count(reservations.id) total, MONTHNAME(reservations.updated_at) month')
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->get();
    }

    public function getAllSales(): Collection
    {
        return DB::table('reservations')
            ->where('seat_status', '2')
            ->selectRaw('count(id) total, MONTHNAME(updated_at) month')
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->get();
    }

    public function getBySeatAndTrip(string $seat, int $tripId): ?Reservation
    {
        return Reservation::where('seat_number', $seat)
            ->where('trip_id', $tripId)
            ->first();
    }

    public function getByTrip(int $tripId)
    {
        return Reservation::where('trip_id', $tripId)->get();
    }
}


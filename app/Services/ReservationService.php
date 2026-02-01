<?php

namespace App\Services;

use App\Repositories\Reservation\ReservationRepository;

class ReservationService
{
    public function __construct(private readonly ReservationRepository $reservationRepo)
    {
    }

    public function updateSeats(array $seats, int $tripId, int $paymentId, int $status): void
    {
        foreach ($seats as $seat) {
            $seatNo = rtrim($seat, ',');
            $reservation = $this->reservationRepo->getBySeatAndTrip($seatNo, $tripId);

            if ($reservation) {
                $reservation->update([
                    'payment_id'  => $paymentId,
                    'seat_status' => $status,
                ]);
            }
        }
    }
}

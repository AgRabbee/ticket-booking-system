<?php

namespace App\Services;

use App\Enums\Status;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Keeps the portfolio demo bookable: trips are dated, so seeded data goes
 * stale. This adds a handful of fresh trips, each run by a demo operator.
 */
class DemoTripService
{
    public const TRIPS = 5;

    private const SEATS = 40;

    /** Fictional operators; one is picked at random for each trip. */
    private const OPERATORS = [
        'Padma Express',
        'Meghna Paribahan',
        'Jamuna Line',
        'Surma Deluxe',
        'Karnaphuli Coach',
        'Teesta Classic',
        'Rupsha Travels',
        'Sundarban Paribahan',
    ];

    private const DRIVERS = ['Karim', 'Rahim', 'Salam', 'Jamal', 'Babul', 'Faruk', 'Milon', 'Sohel'];

    /** [from, to, fare] */
    private const ROUTES = [
        ['Dhaka', 'Chattogram', 850],
        ['Dhaka', "Cox's Bazar", 1200],
        ['Dhaka', 'Sylhet', 700],
        ['Dhaka', 'Rajshahi', 750],
        ['Dhaka', 'Khulna', 800],
        ['Dhaka', 'Rangpur', 900],
        ['Dhaka', 'Barishal', 650],
    ];

    private const TIMES = ['6:45 AM', '7:30 AM', '8:00 AM', '9:00 AM', '9:15 PM', '10:00 PM', '10:30 PM', '11:00 PM'];

    public function hasBookableTrips(): bool
    {
        return DB::table('trips')
            ->join('reservations', 'reservations.trip_id', 'trips.id')
            ->where('trips.date', '>', date('Y-m-d'))
            ->where('reservations.seat_status', 0)
            ->exists();
    }

    /**
     * @return int number of trips created
     */
    public function generate(int $trips = self::TRIPS): int
    {
        $districts = DB::table('districts')->pluck('id', 'name');
        $busTypeId = DB::table('transports')->where('transport_type', 'Bus')->value('id');
        $routes = array_filter(self::ROUTES, fn($route) => isset($districts[$route[0]], $districts[$route[1]]));

        if (!$busTypeId || !$routes) {
            return 0;
        }

        return DB::transaction(function () use ($trips, $districts, $busTypeId, $routes) {
            $created = 0;

            foreach (Arr::random($routes, min($trips, count($routes))) as $index => [$from, $to, $fare]) {
                $operator = $this->operator(Arr::random(self::OPERATORS), $busTypeId);
                [$start, $end] = random_int(0, 1) ? [$from, $to] : [$to, $from];

                $tripId = DB::table('trips')->insertGetId([
                    'company_id'  => $operator->company_id,
                    // Spread over the coming days so the demo stays bookable for about a week.
                    'date'        => Carbon::today()->addDays($index + 1 + intdiv($index, 2))->toDateString(),
                    'start_time'  => Arr::random(self::TIMES),
                    'bus_id'      => $operator->bus_id,
                    'start_point' => $districts[$start],
                    'end_point'   => $districts[$end],
                    'fare'        => $fare,
                    'driver_id'   => $operator->driver_id,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);

                $this->addSeats($tripId);
                $created++;
            }

            return $created;
        });
    }

    /**
     * Finds the demo operator by name, or creates it with one bus and one driver.
     */
    private function operator(string $name, int $busTypeId): object
    {
        $company = DB::table('companies')->where('company_name', $name)->first();

        if (!$company) {
            $companyId = DB::table('companies')->insertGetId([
                'company_name'   => $name,
                'description'    => 'Demo intercity bus operator',
                'address'        => 'Dhaka',
                'reg_no'         => 'DEMO-' . random_int(1000, 9999),
                'tin_no'         => random_int(100000000, 999999999),
                'company_image'  => 'company1.png',
                'trade'          => 'Transport',
                'vat'            => 'VAT-DEMO',
                'fees'           => 5000,
                'company_status' => Status::ACTIVE->value,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        } else {
            $companyId = $company->id;
        }

        $busId = DB::table('company_transport')->where('company_id', $companyId)->value('id')
            ?? DB::table('company_transport')->insertGetId([
                'company_id'        => $companyId,
                'transport_type_id' => $busTypeId,
                'total_seats'       => self::SEATS,
                'registration_no'   => 'DEMO-' . random_int(1000, 9999),
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);

        $driverId = DB::table('company_user')
            ->join('role_user', 'role_user.user_id', 'company_user.user_id')
            ->join('roles', 'roles.id', 'role_user.role_id')
            ->where('company_user.company_id', $companyId)
            ->where('roles.name', 'Driver')
            ->value('company_user.id')
            ?? $this->driver($companyId);

        return (object)[ 'company_id' => $companyId, 'bus_id' => $busId, 'driver_id' => $driverId ];
    }

    private function driver(int $companyId): int
    {
        $userId = DB::table('users')->insertGetId([
            'first_name'  => Arr::random(self::DRIVERS),
            'last_name'   => 'Demo driver',
            'phone'       => '017' . random_int(10000000, 99999999),
            'user_status' => Status::ACTIVE->value,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        if ($driverRoleId = DB::table('roles')->where('name', 'Driver')->value('id')) {
            DB::table('role_user')->insert([ 'user_id' => $userId, 'role_id' => $driverRoleId ]);
        }

        return DB::table('company_user')->insertGetId([
            'user_id'    => $userId,
            'company_id' => $companyId,
            'status'     => Status::ACTIVE->value,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function addSeats(int $tripId): void
    {
        $rows = [];
        for ($row = 'A'; $row <= 'J'; $row++) {
            for ($col = 1; $col < 5; $col++) {
                $rows[] = [
                    'seat_number' => $row . $col,
                    'seat_status' => 0,
                    'trip_id'     => $tripId,
                ];
            }
        }

        DB::table('reservations')->insert(array_slice($rows, 0, self::SEATS));
    }
}

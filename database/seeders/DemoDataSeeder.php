<?php

namespace Database\Seeders;

use App\Enums\Status;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

/**
 * Empties every table except `districts` and `transports`, keeps only the main
 * system admin in `users`, then fills everything with a new, consistent data
 * set: all user roles, three active companies and one pending, buses, drivers,
 * past trips with sales and upcoming bookable trips.
 *
 *   php artisan db:seed --class=DemoDataSeeder
 */
class DemoDataSeeder extends Seeder
{
    private const ADMIN_EMAIL = 'admin@tbs.com';

    private const PASSWORD = '123456';

    private const SEATS = 40;

    private const FEE = 21;

    private array $roles = [];

    private array $districts = [];

    private int $busTypeId;

    public function run(): void
    {
        $this->districts = DB::table('districts')->pluck('id', 'name')->all();
        $this->busTypeId = (int)DB::table('transports')->where('transport_type', 'Bus')->value('id');

        if (!$this->districts || !$this->busTypeId) {
            $this->command?->error('The districts and transports tables must be filled first.');

            return;
        }

        mt_srand(20261008);
        $this->wipe();

        DB::transaction(function () {
            $this->seedRoles();
            $this->seedStaff();
            $customers = $this->seedCustomers();
            $passengers = $this->seedPassengers();
            $companies = $this->seedCompanies($customers['pending_owner']);
            $this->seedTrips($companies, $passengers);
        });
    }

    private function wipe(): void
    {
        Schema::disableForeignKeyConstraints();

        foreach ([
            'reservations', 'payment_details', 'trips', 'company_transport', 'company_user',
            'companies', 'role_user', 'roles', 'password_resets', 'personal_access_tokens',
        ] as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->truncate();
            }
        }

        // The main system admin is the one row that survives, untouched.
        DB::table('users')->where('email', '!=', self::ADMIN_EMAIL)->orWhereNull('email')->delete();
        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE users AUTO_INCREMENT = 2');
        }

        Schema::enableForeignKeyConstraints();
    }

    private function seedRoles(): void
    {
        $roles = [
            1 => ['Super Admin', 'Super Admin has the full power of this application'],
            2 => ['Admin', 'Admin has only access to his own company account'],
            3 => ['Driver', 'Driver has only access to his own account through mobile application'],
            4 => ['Customer', 'Customer has only access to his own account'],
        ];

        foreach ($roles as $id => [$name, $description]) {
            DB::table('roles')->insert([
                'id'          => $id,
                'name'        => $name,
                'description' => $description,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
            $this->roles[$name] = $id;
        }
    }

    /**
     * The main system admin is kept as it is (created only on an empty database);
     * the demo admin is the one published on the sign-in page.
     */
    private function seedStaff(): void
    {
        $adminId = DB::table('users')->where('email', self::ADMIN_EMAIL)->value('id');

        if ($adminId) {
            DB::table('role_user')->insert(['user_id' => $adminId, 'role_id' => $this->roles['Super Admin']]);
        } else {
            $this->user('System', 'Admin', self::ADMIN_EMAIL, '01711000001', Status::ACTIVE, ['Super Admin']);
        }

        $this->user('Demo', 'Admin', config('demo.logins.admin'), '01711000002', Status::ACTIVE, ['Super Admin']);
    }

    /**
     * Registered customers in every state an admin has to handle.
     */
    private function seedCustomers(): array
    {
        $this->user('Demo', 'Traveller', config('demo.logins.traveller'), '01711000003', Status::ACTIVE, ['Customer']);
        $this->user('Nusrat', 'Jahan', 'nusrat.jahan@example.com', '01712345601', Status::ACTIVE, ['Customer']);
        $this->user('Tanvir', 'Ahmed', 'tanvir.ahmed@example.com', '01812345602', Status::ACTIVE, ['Customer']);
        $pendingOwner = $this->user('Farhana', 'Islam', 'farhana.islam@example.com', '01912345603', Status::ACTIVE, ['Customer']);

        // Waiting for approval, and one that was turned down: no role until an admin activates them.
        $this->user('Imran', 'Hossain', 'imran.hossain@example.com', '01612345604', Status::PENDING, []);
        $this->user('Sadia', 'Akter', 'sadia.akter@example.com', '01512345605', Status::PENDING, []);
        $this->user('Rakib', 'Hasan', 'rakib.hasan@example.com', '01712345606', Status::DENIED, []);

        return ['pending_owner' => $pendingOwner];
    }

    /**
     * Guest passengers, created the way checkout creates them: no password, no role.
     */
    private function seedPassengers(): array
    {
        $names = [
            ['Mahmudul', 'Hasan'], ['Sharmin', 'Sultana'], ['Arif', 'Rahman'], ['Tasnim', 'Khan'],
            ['Shakil', 'Mia'], ['Rumana', 'Begum'], ['Nayeem', 'Uddin'], ['Jannatul', 'Ferdous'],
            ['Sajib', 'Chowdhury'], ['Mitu', 'Akter'], ['Habib', 'Sarker'], ['Lamia', 'Haque'],
        ];

        $ids = [];
        foreach ($names as $i => [$first, $last]) {
            $ids[] = DB::table('users')->insertGetId([
                'first_name'  => $first,
                'last_name'   => $last,
                'email'       => strtolower($first . '.' . $last) . '@example.com',
                'phone'       => '017' . str_pad((string)(55500100 + $i * 37), 8, '0', STR_PAD_LEFT),
                'user_status' => Status::PENDING->value,
                'created_at'  => now()->subDays(70 - $i * 5),
                'updated_at'  => now()->subDays(70 - $i * 5),
            ]);
        }

        return $ids;
    }

    private function seedCompanies(int $pendingOwnerId): array
    {
        $definitions = [
            [
                'name'    => 'Karnaphuli Coach',
                'about'   => 'Intercity AC coach service from Dhaka to the major divisional cities.',
                'address' => 'Gabtoli Bus Terminal, Dhaka',
                'admin'   => ['Demo', 'Operator', config('demo.logins.company'), '01711000004'],
                'drivers' => [['Abdul', 'Karim'], ['Jamal', 'Uddin']],
                'buses'   => ['DHAKA-METRO-BA-11-2345', 'DHAKA-METRO-BA-11-2346'],
            ],
            [
                'name'    => 'Padma Express',
                'about'   => 'Overnight and day coaches on the Dhaka, Khulna and Barishal corridor.',
                'address' => 'Sayedabad Bus Terminal, Dhaka',
                'admin'   => ['Rashed', 'Mahmud', 'rashed.mahmud@example.com', '01811000010'],
                'drivers' => [['Rafiqul', 'Islam'], ['Babul', 'Mia']],
                'buses'   => ['DHAKA-METRO-BA-14-5510', 'KHULNA-BA-11-0872'],
            ],
            [
                'name'    => 'Meghna Paribahan',
                'about'   => 'Daily services linking Dhaka with Chattogram, Cox\'s Bazar and Sylhet.',
                'address' => 'Kalabagan, Dhaka',
                'admin'   => ['Shahidul', 'Alam', 'shahidul.alam@example.com', '01911000020'],
                'drivers' => [['Faruk', 'Hossain'], ['Sohel', 'Rana']],
                'buses'   => ['CHATTA-METRO-BA-11-3391', 'DHAKA-METRO-BA-15-7204'],
            ],
        ];

        $companies = [];
        foreach ($definitions as $i => $definition) {
            $companyId = $this->company($definition['name'], $definition['about'], $definition['address'], $i + 1, Status::ACTIVE);

            // The company admin has to be the company's first user and holds Customer then Admin, in that order.
            [$first, $last, $email, $phone] = $definition['admin'];
            $adminId = $this->user($first, $last, $email, $phone, Status::ACTIVE, ['Customer', 'Admin']);
            $this->companyUser($adminId, $companyId, Status::ACTIVE);

            $drivers = [];
            foreach ($definition['drivers'] as $j => [$driverFirst, $driverLast]) {
                $driverId = $this->user(
                    $driverFirst,
                    $driverLast,
                    strtolower($driverFirst . '.' . $driverLast) . '@example.com',
                    '0131' . str_pad((string)($i * 100 + $j + 1), 7, '0', STR_PAD_LEFT),
                    Status::ACTIVE,
                    ['Driver']
                );
                $drivers[] = $this->companyUser($driverId, $companyId, Status::ACTIVE);
            }

            $buses = [];
            foreach ($definition['buses'] as $registration) {
                $buses[] = DB::table('company_transport')->insertGetId([
                    'company_id'        => $companyId,
                    'transport_type_id' => $this->busTypeId,
                    'total_seats'       => self::SEATS,
                    'registration_no'   => $registration,
                    'created_at'        => now()->subDays(80),
                    'updated_at'        => now()->subDays(80),
                ]);
            }

            $companies[] = ['id' => $companyId, 'drivers' => $drivers, 'buses' => $buses];
        }

        // A registration request still waiting for the system admin.
        $pendingId = $this->company(
            'Jamuna Line',
            'New operator applying to run services between Dhaka and Rangpur.',
            'Mohakhali Bus Terminal, Dhaka',
            4,
            Status::PENDING
        );
        $this->companyUser($pendingOwnerId, $pendingId, Status::PENDING);

        return $companies;
    }

    private function seedTrips(array $companies, array $passengers): void
    {
        // [company index, from, to, fare, time, day offset from today]
        $trips = [
            [0, 'Dhaka', 'Chattogram', 850, '7:30 AM', -64],
            [1, 'Dhaka', 'Khulna', 800, '8:30 AM', -52],
            [2, 'Dhaka', 'Sylhet', 700, '11:00 PM', -41],
            [0, 'Chattogram', 'Dhaka', 850, '10:30 PM', -33],
            [2, 'Dhaka', "Cox's Bazar", 1200, '9:30 PM', -24],
            [1, 'Barishal', 'Dhaka', 650, '9:15 PM', -16],
            [0, 'Dhaka', 'Rajshahi', 750, '9:00 AM', -8],
            [2, 'Sylhet', 'Dhaka', 700, '6:45 AM', -3],

            [0, 'Dhaka', 'Chattogram', 850, '7:30 AM', 1],
            [2, 'Dhaka', "Cox's Bazar", 1200, '9:30 PM', 2],
            [1, 'Dhaka', 'Khulna', 800, '8:30 AM', 3],
            [2, 'Dhaka', 'Sylhet', 700, '11:00 PM', 4],
            [0, 'Dhaka', 'Rajshahi', 750, '9:00 AM', 6],
            [1, 'Dhaka', 'Barishal', 650, '9:15 PM', 8],
        ];

        $seats = [];
        for ($row = 'A'; $row <= 'J'; $row++) {
            for ($col = 1; $col < 5; $col++) {
                $seats[] = $row . $col;
            }
        }

        foreach ($trips as $n => [$c, $from, $to, $fare, $time, $offset]) {
            $company = $companies[$c];
            $date = Carbon::today()->addDays($offset);
            $published = $date->copy()->subDays(10);

            $tripId = DB::table('trips')->insertGetId([
                'company_id'  => $company['id'],
                'date'        => $date->toDateString(),
                'start_time'  => $time,
                'bus_id'      => $company['buses'][$n % count($company['buses'])],
                'start_point' => $this->districts[$from],
                'end_point'   => $this->districts[$to],
                'fare'        => $fare,
                'driver_id'   => $company['drivers'][$n % count($company['drivers'])],
                'created_at'  => $published,
                'updated_at'  => $published,
            ]);

            // Past trips sold most of the bus; upcoming ones have only a few seats taken so far.
            $sold = $offset < 0 ? mt_rand(18, 34) : mt_rand(3, 9);
            $taken = [];
            $free = $seats;
            shuffle($free);

            while (count($taken) < $sold) {
                $group = array_splice($free, 0, min(mt_rand(1, 3), $sold - count($taken)));
                $bookedAt = $offset < 0
                    ? $date->copy()->subDays(mt_rand(1, 7))->setTime(mt_rand(8, 22), mt_rand(0, 59))
                    : Carbon::now()->subDays(mt_rand(0, 2))->subMinutes(mt_rand(5, 600));

                $paymentId = DB::table('payment_details')->insertGetId([
                    'user_id'        => $passengers[mt_rand(0, count($passengers) - 1)],
                    'payment_status' => 1,
                    'payment_type'   => 0,
                    'stripe_token'   => 'tok_demo_' . substr(md5($tripId . implode('', $group)), 0, 16),
                    'created_at'     => $bookedAt,
                    'updated_at'     => $bookedAt,
                ]);

                foreach ($group as $seat) {
                    $taken[$seat] = ['payment_id' => $paymentId, 'seat_status' => 2, 'at' => $bookedAt];
                }
            }

            $rows = [];
            foreach ($seats as $seat) {
                $rows[] = [
                    'payment_id'  => $taken[$seat]['payment_id'] ?? null,
                    'seat_number' => $seat,
                    'seat_status' => $taken[$seat]['seat_status'] ?? 0,
                    'trip_id'     => $tripId,
                    'created_at'  => $published,
                    'updated_at'  => $taken[$seat]['at'] ?? $published,
                ];
            }
            DB::table('reservations')->insert($rows);
        }
    }

    private function user(string $first, string $last, string $email, string $phone, Status $status, array $roles, ?string $password = null): int
    {
        static $password123;
        $password123 ??= Hash::make(self::PASSWORD);

        $id = DB::table('users')->insertGetId([
            'first_name'  => $first,
            'last_name'   => $last,
            'email'       => $email,
            'password'    => $password ?? $password123,
            'phone'       => $phone,
            'nid'         => mt_rand(100000000, 999999999),
            'user_status' => $status->value,
            'created_at'  => now()->subDays(90),
            'updated_at'  => now()->subDays(90),
        ]);

        foreach ($roles as $role) {
            DB::table('role_user')->insert(['user_id' => $id, 'role_id' => $this->roles[$role]]);
        }

        return $id;
    }

    private function company(string $name, string $about, string $address, int $number, Status $status): int
    {
        return DB::table('companies')->insertGetId([
            'company_name'   => $name,
            'description'    => $about,
            'address'        => $address,
            'reg_no'         => 'REG-' . str_pad((string)$number, 3, '0', STR_PAD_LEFT),
            'tin_no'         => 123456780 + $number,
            'company_image'  => 'company' . $number . '.png',
            'trade'          => 'trade-licence-' . $number . '.png',
            'vat'            => 'vat-certificate-' . $number . '.png',
            'fees'           => 5000,
            'company_status' => $status->value,
            'created_at'     => now()->subDays(85),
            'updated_at'     => now()->subDays(85),
        ]);
    }

    private function companyUser(int $userId, int $companyId, Status $status): int
    {
        return DB::table('company_user')->insertGetId([
            'user_id'    => $userId,
            'company_id' => $companyId,
            'status'     => $status->value,
            'created_at' => now()->subDays(85),
            'updated_at' => now()->subDays(85),
        ]);
    }
}

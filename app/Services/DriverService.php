<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class DriverService
{
    /**
     * @throws Throwable
     */
    public function createDriver(array $data, int $companyId): void
    {
        DB::beginTransaction();

        try {
            $driver = User::create([
                'first_name'  => $data['first_name'],
                'last_name'   => $data['last_name'],
                'email'       => $data['email'] ?? null,
                'phone'       => $data['phone'],
                'password'    => $data['password'],
                'nid'         => $data['nid'],
                'user_status' => 1,
            ]);

            $driver->roles()->attach(
                Role::where('name', 'Driver')->first()
            );

            $driver->companies()->attach($companyId, [ 'status' => 1 ]);

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('Driver creation failed', [ 'error' => $e->getMessage() ]);
            throw $e;
        }
    }
}


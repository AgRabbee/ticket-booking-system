<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Trip extends Model
{
    public function allTripsForSuperAdmin(): Collection
    {
        return DB::table('trips')
            ->selectRaw('trips.*,s.name as start_name, e.name as end_name, companies.*, company_transport.*')
            ->join('districts as s', 's.id', '=', 'trips.start_point')
            ->join('districts as e', 'e.id', '=', 'trips.end_point')
            ->join('companies', 'companies.id', '=', 'trips.company_id')
            ->join('company_transport', 'company_transport.id', '=', 'trips.bus_id')
            ->get();
    }

    public function allTrips($company_id): Collection
    {
        return DB::table('trips')
            ->selectRaw('trips.*,trips.id as t_id,s.name as start_name, e.name as end_name,users.*')
            ->join('districts as s', 's.id', '=', 'trips.start_point')
            ->join('districts as e', 'e.id', '=', 'trips.end_point')
            ->join('company_user', 'company_user.id', '=', 'trips.driver_id')
            ->join('users', 'users.id', '=', 'company_user.user_id')
            ->where('trips.company_id', '=', $company_id)
            ->orderBy('trips.id', 'DESC')
            ->get();
    }

    public function allLocations(): Collection
    {
        return DB::table('districts')->get();
    }

    public function allRoutes(): Collection
    {
        return DB::table('trips')
            ->selectRaw('s.name as start_name, e.name as end_name, trips.*')
            ->join('districts as s', 's.id', '=', 'trips.start_point')
            ->join('districts as e', 'e.id', '=', 'trips.end_point')
            ->where('date', '>', date("Y-m-d"))
            ->get();
    }

    public function allBuses(): Collection
    {
        return DB::table('company_transport as ct')
            ->selectRaw('ct.id')
            ->join('companies as c', 'ct.company_id', '=', 'c.id')
            ->join('transports as t', 'ct.transport_type_id', '=', 't.id')
            ->where('company_id', '=', Auth::user()->companies[0]->id)
            ->where('t.transport_type', 'Bus')
            ->get();
    }

    public function allDrivers(): Collection
    {
        return DB::table('users')
            ->selectRaw('users.*,company_user.*,company_user.id as cm_id')
            ->join('role_user', 'users.id', 'role_user.user_id')
            ->join('company_user', 'users.id', 'company_user.user_id')
            ->where('company_user.company_id', Auth::user()->companies[0]->id)
            ->where('role_user.role_id', '3')
            ->get();
    }

    public function searchTrips($from, $to, $date): Collection
    {
        return DB::table('trips')
            ->selectRaw('trips.*,trips.id as t_id,s.name as start_name, e.name as end_name,companies.*,company_transport.*')
            ->join('companies', 'trips.company_id', 'companies.id')
            ->join('company_transport', 'trips.bus_id', 'company_transport.id')
            ->join('districts as s', 's.id', '=', 'trips.start_point')
            ->join('districts as e', 'e.id', '=', 'trips.end_point')
            ->where('trips.start_point', $from)
            ->where('trips.end_point', $to)
            ->where('trips.date', $date)
            ->get();
    }

    public function tripDetails($trip_id): Collection
    {
        return DB::table('trips')
            ->selectRaw('trips.*,trips.id as t_id,s.name as start_name, e.name as end_name,companies.*,company_transport.*')
            ->join('companies', 'trips.company_id', 'companies.id')
            ->join('company_transport', 'trips.bus_id', 'company_transport.id')
            ->join('districts as s', 's.id', '=', 'trips.start_point')
            ->join('districts as e', 'e.id', '=', 'trips.end_point')
            ->where('trips.id', $trip_id)
            ->get();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Reservation extends Model
{
    // public function allocations($trip_id)
    // {
    //     $allocation = DB::table('reservations')
    //                     ->join('payment_details','payment_details.id','reservations.payment_id')
    //                     ->join('trips','trips.id','reservations.trip_id')
    //                     ->where('reservations.trip_id',$trip_id)
    //                     ->get();
    //
    //     return $allocation;
    // }


    public function allocations($trip_id)
    {
        $details = DB::table('reservations')
                    ->selectRaw('reservations.*')
                    ->join('payment_details','reservations.payment_id','payment_details.id')
                    ->join('trips','reservations.trip_id','trips.id')
                    ->where('reservations.trip_id',$trip_id)
                    ->get();

        return $details;
    }


    public function dataForPrint($paymentID)
    {


        $details = DB::table('reservations')
                    ->selectRaw('users.first_name, users.last_name, users.phone, users.email, companies.company_name, reservations.seat_number, reservations.seat_status, payment_details.id, payment_details.payment_status, payment_details.created_at, trips.date, trips.start_time, s.name as startPoint, e.name as endPoint, trips.fare')
                    ->join('payment_details','reservations.payment_id','payment_details.id')
                    ->join('users','payment_details.user_id','users.id')
                    ->join('trips','reservations.trip_id','trips.id')
                    ->join('companies','trips.company_id','companies.id')
                    ->join('districts as s','s.id','=','trips.start_point')
                    ->join('districts as e','e.id','=','trips.end_point')
                    ->where('reservations.payment_id',$paymentID)
                    ->get();
        return $details;
    }


    public function allSales($company_id)
    {
        // SELECT payment_details.id, users.first_name, users.last_name, reservations.seat_number, trips.date, trips.start_time, trips.start_point, trips.end_point, trips.bus_id
        // FROM payment_details, users, reservations, trips, companies WHERE
        // payment_details.id = reservations.payment_id AND
        // payment_details.user_id = users.id AND
        // reservations.trip_id = trips.id AND
        // trips.company_id = companies.id AND
        // companies.id = 2


        $details = DB::table('reservations')
                    ->selectRaw('payment_details.id as pId, payment_details.stripe_token, users.first_name, users.last_name, reservations.seat_number, trips.date, trips.start_time, trips.bus_id, s.name as startPoint, e.name as endPoint, trips.fare')
                    ->join('payment_details','reservations.payment_id','payment_details.id')
                    ->join('users','payment_details.user_id','users.id')
                    ->join('trips','reservations.trip_id','trips.id')
                    ->join('companies','trips.company_id','companies.id')
                    ->join('districts as s','s.id','=','trips.start_point')
                    ->join('districts as e','e.id','=','trips.end_point')
                    ->where('companies.id',$company_id)
                    ->get();
        return $details;


    }
}

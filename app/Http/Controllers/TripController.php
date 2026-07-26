<?php

namespace App\Http\Controllers;

use App\Models\CompanyTransport;
use App\Models\Reservation;
use App\Models\Trip;
use App\Services\TripService;
use Auth;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function __construct(private readonly TripService $tripService)
    {
        Parent::__construct();
    }

    public function index()
    {
        return view('company_admin.all_trips')->with('trips', $this->tripService->allTrips(Auth::user()->companies[0]->id));
    }

    public function allTrips()
    {
        return view('admin.allTrips')->with('trips', $this->tripService->allTripsForSuperAdmin());
    }

    public function create()
    {
        return view('company_admin.add_trips')->with([
            'locations' => $this->tripService->allLocations(),
            'buses'     => $this->tripService->allBuses(),
            'drivers'   => $this->tripService->allDrivers(),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'date'           => 'required|date',
            'time'           => 'required|string',
            'starting_point' => 'required|integer',
            'end_point'      => 'required|integer',
            'fare'           => 'required|regex:/^[1-9][0-9]+/|not_in:0',
            'driver_id'      => 'required|integer|',
            'bus_id'         => 'required|integer|',
        ]);

        $trip = new Trip;
        $trip->company_id = Auth::user()->companies[0]->id;
        $trip->date = $request['date'];
        $trip->start_time = $request['time'];
        $trip->bus_id = $request['bus_id'];
        $trip->start_point = $request['starting_point'];
        $trip->end_point = $request['end_point'];
        $trip->fare = $request['fare'];
        $trip->driver_id = $request['driver_id'];
        $trip->save();
        $trip_id = $trip->id;
        $company_transport = CompanyTransport::find($request['bus_id']);


        for ($i = 'A'; $i <= 'J'; $i++) {
            for ($y = 1; $y < 5; $y++) {
                $seats[] = $i . $y;
            }
        }

        for ($i = 0; $i < $company_transport->total_seats; $i++) {
            $data2 = [
                'seat_number' => $seats[$i],
                'seat_status' => 0,
                'trip_id'     => $trip_id,
            ];
            Reservation::insert($data2);
        }

        return redirect()->back()->withSuccessMessage('Trip Added Successfully');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'update_fare' => 'required|regex:/^[1-9][0-9]+/|not_in:0',
        ]);
        $update_trip = Trip::find($id);
        $update_trip->fare = $request['update_fare'];
        $update_trip->save();

        return redirect()->back()->withSuccessMessage('Trips Fare updated Successfully..');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompletePaymentRequest;
use App\Http\Requests\ContactAdminRequest;
use App\Http\Requests\SearchTripRequest;
use App\Mail\BookingMail;
use App\Mail\ContactMail;
use App\Models\Reservation;
use App\Repositories\Payment\PaymentRepository;
use App\Repositories\Reservation\ReservationRepository;
use App\Repositories\User\UserRepository;
use App\Services\PaymentService;
use App\Services\ReservationService;
use App\Services\TripService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class PagesController extends Controller
{
    public function __construct(
        private readonly TripService           $tripService,
        private readonly UserRepository        $userRepo,
        private readonly PaymentRepository     $paymentRepo,
        private readonly ReservationRepository $reservationRepo,
        private readonly PaymentService        $paymentService,
        private readonly ReservationService    $reservationService
    )
    {
        Parent::__construct();
    }

    public function index()
    {
        return view('welcome');
    }

    public function bus()
    {
        return view('bus.index')->with([
            'tripsInfo' => $this->tripService->allLocations(),
            'allRoutes' => $this->tripService->allRoutes(),
        ]);
    }

    public function contact_form()
    {
        return view('bus.contact_admin');
    }

    public function completePayment(CompletePaymentRequest $request)
    {
        DB::beginTransaction();

        try {
            /** User creation */
            $user = $this->userRepo->create([
                'first_name'  => $request->f_name,
                'last_name'   => $request->l_name,
                'phone'       => $request->phone,
                'email'       => $request->email,
                'user_status' => 0,
            ]);

            /** Stripe payment */
            if ($request->stripeToken) {
                $this->paymentService->charge($request->all());
            }

            /** Payment record */
            $payment = $this->paymentRepo->create([
                'user_id'        => $user->id,
                'payment_status' => $request->stripeToken ? 1 : 0,
                'payment_type'   => $request->stripeToken ? 0 : 1,
                'stripe_token'   => $request->stripeToken,
                'user_address'   => $request->address,
            ]);

            /** Seat update */
            $this->reservationService->updateSeats(
                $request->seats,
                (int)$request->tripId,
                $payment->id,
                $request->stripeToken ? 2 : 1
            );

            DB::commit();

            $request->session()->put('newPaymentID', $payment->id);

            /** Mail */
            if ($request->email) {
                $data = (new Reservation())->dataForPrint($payment->id);
                Mail::to($request->email)->send(new BookingMail($data));
            }

            return redirect('/print')->withSuccessMessage('Payment Successful');

        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('Complete payment failed', [
                'error' => $e->getMessage(),
            ]);

            return back()->withErrors('Payment failed. Please try again.');
        }
    }

    public function search(SearchTripRequest $request)
    {
        $results = $this->tripService->search(
            $request->from,
            $request->to,
            $request->date_of_journey
        );

        return $results->count() > 0
            ? view('bus.search_details')->with('search_details', $results)
            : back()->withInfoMessage('Trips not found. Try another destination.');
    }

    /* -----------------------------
     |  Seat Allocation
     |-----------------------------*/
    public function seat_allocations(Request $request)
    {
        return response()->json([
            'success' => $this->reservationRepo->getByTrip($request->trip_id),
        ]);
    }

    public function prebooking(Request $request)
    {
        if (!$request->seats) {
            session()->flash('type', 'danger');
            session()->flash('message', 'You did not select any seats. Try again');

            return redirect('/');
        }

        return view('bus.prebooking')->with([
            'trip_id'        => $request->trip_id,
            'seats'          => $request->seats,
            'total'          => $request->total,
            'boarding_point' => $request->boarding_point,
            'tripDetails'    => $this->tripService->tripDetails($request->trip_id),
        ]);
    }

    public function print(Request $request)
    {
        $paymentId = $request->session()->get('newPaymentID');
        $data = new Reservation();

        return view('bus.print')->with(
            'printDetails',
            $data->dataForPrint($paymentId)
        );
    }

    public function print_invoice(Request $request)
    {
        $paymentId = $request->session()->get('newPaymentID');
        $data = new Reservation();

        return view('bus.print_invoice')->with(
            'printDetails',
            $data->dataForPrint($paymentId)
        );
    }

    public function contact_admin(ContactAdminRequest $request)
    {
        Mail::to($request->email)->send(new ContactMail([
            'subject' => $request->subject,
            'email'   => $request->email,
            'msg'     => $request->msg,
        ]));

        return redirect('/contact')->withSuccessMessage('Your Message has been sent!!!');
    }
}

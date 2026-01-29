@extends('layouts.public')
@section('content')

<!--SEARCH-BAR-->
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="invoice p-5 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> Ticket Booking System
                    <small class="float-right">Date: {{date('d-m-Y')}}</small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>

    {{-- @foreach ($printDetails as $value) --}}

              <!-- info row -->
              <div class="row invoice-info py-3">
                <div class="col-sm-3 invoice-col">
                  From
                  <address>
                    <strong>Admin, Inc.</strong><br>
                    Phone: (804) 123-5432<br>
                    Email: admin@tbs.com
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-3 invoice-col">
                  To
                  <address>
                    <strong>{{ $printDetails[0]->first_name . ' ' . $printDetails[0]->last_name}}</strong><br>
                    Phone: {{ $printDetails[0]->phone }}<br>
                    Email: {{ $printDetails[0]->email}}
                  </address>
                </div>

                <!-- /.col -->
                <div class="col-sm-3 invoice-col">
                  <b>Payment ID:</b> {{ $printDetails[0]->id}}<br>
                  <b>Payment Date:</b> {{ date('d-M-y', strtotime($printDetails[0]->created_at))}}<br>
                </div>
                <!-- /.col -->

                <!-- /.col -->
                <div class="col-sm-3 invoice-col">
                  <b>Journey:</b> {{ $printDetails[0]->startPoint}} - {{ $printDetails[0]->endPoint }}<br>
                  <b>Company name:</b> {{ $printDetails[0]->company_name}}<br>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
              <!-- Table row -->
              <div class="row py-5">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>Qty</th>
                      <th>Seat Number</th>
                      <th>Date</th>
                      <th>Start Time</th>
                      <th>Fare</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php
                            $total = 0;
                        @endphp
                        @for ($i=0; $i < count($printDetails); $i++)
                            @php
                                $total = $printDetails[$i]->fare * count($printDetails);
                            @endphp
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td>{{ $printDetails[$i]->seat_number }}</td>
                                <td>{{ $printDetails[$i]->date }}</td>
                                <td>{{ $printDetails[$i]->start_time }}</td>
                                <td>{{ $printDetails[$i]->fare }}</td>

                            </tr>
                        @endfor

                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                  <p class="lead">Payment Methods:</p>
                  <img src="{!! asset('images/stripe.png') !!}" width="80" height="50" alt="Stripe">

                  <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                    Stripe is an American technology company based in San Francisco, California. Its software allows individuals and businesses to make and receive payments over the Internet.
                  </p>
                </div>
                <!-- /.col -->
                <div class="col-6">

                  <div class="table-responsive">
                    <table class="table">
                      <tbody>
                      <tr>
                        <th>Ticket Price:</th>
                        <td>{{ $total }}/-</td>
                      </tr>
                      <tr>
                        <th>System Fee:</th>
                        <td>21/-</td>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td>{{$total+21}}/-</td>
                      </tr>
                    </tbody></table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

          {{-- @endforeach --}}



              <!-- this row will not appear when printing -->
              {{-- <div class="row no-print">
                <div class="col-12">
                  <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                </div>
              </div> --}}
            </div>
            </div>
        </div>
    </div>

<!--SEARCH-BAR-END-->

@endsection

@section('public_css')
    <style type="text/css" media="print">
        @page
        {
            size:  auto;   /* auto is the initial value */
            margin: 0mm;  /* this affects the margin in the printer settings */
        }

        html
        {
            background-color: #FFFFFF;
            margin: 0px;  /* this affects the margin on the html before sending to printer */
        }

        body
        {
            /* border: solid 1px blue ; */
            /* margin: 10mm 15mm 10mm 15mm; /* margin you want for the content */ */
        }
        </style>
@endsection



@section('public_scripts')
<script type="text/javascript">
    $(document).ready(function () {
      window.print();
    });
</script>
@endsection

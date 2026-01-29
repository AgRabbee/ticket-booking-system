<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Ticket Booking System</title>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12 border bd-info p-2">
                    <h1>Success!!</h1>
                </div>
            </div>

            <div class="row">
                <h2>hi, {{ $data[0]->first_name . ' ' . $data[0]->last_name }}</h2>
                <h3>Booking Details</h3>
                <p><b>Payment ID:</b> {{ $data[0]->id}}</p>
                <p><b>Payment Date:</b> {{ date('d-M-y', strtotime($data[0]->created_at))}}</p>


                <p><b>Journey:</b> {{ $data[0]->startPoint}} - {{ $data[0]->endPoint }}</p>
                <p><b>Company name:</b> {{ $data[0]->company_name}}</p>
            </div>

            <!-- Table row -->
            <div class="row py-2">
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
                      @for ($i=0; $i < count($data); $i++)
                          @php
                              $total = $data[$i]->fare * count($data);
                          @endphp
                          <tr>
                              <td>{{ $i+1 }}</td>
                              <td>{{ $data[$i]->seat_number }}</td>
                              <td>{{ $data[$i]->date }}</td>
                              <td>{{ $data[$i]->start_time }}</td>
                              <td>{{ $data[$i]->fare }}</td>

                          </tr>
                      @endfor

                  </tbody>
                </table>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
            <!-- /.row -->

            <div class="row">
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
            <!-- /.row -->

            <div class="row">
                <div class="col-md-12 border bd-info p-2 text-center">
                    <h1>Thanks for being with us!!</h1>
                </div>
            </div>

        </div>


    </body>
</html>

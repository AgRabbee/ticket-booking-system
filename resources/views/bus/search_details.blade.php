@extends('layouts.public')
@section('content')



<!--SEARCH-BAR-->
    <div class="container">
        <div class="row my-5">
            <div class="col-md-12">
                <table id="example1" class="table table-striped display responsive">
                  <thead>
                      <tr>
                          <th>Company name</th>
                          <th>Departure Time</th>
                          <th>Seats Available</th>
                          <th>Fare</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      {{-- @foreach ($search_details as $value) --}}
                      {{-- {{ $search_details = $request->session()->get('search_details')}} --}}
                      @foreach ($search_details as $value)
                      <tr>
                          <td>{{ $value->company_name }}</td>
                          <td>{{ $value->start_time }}</td>
                          <td>{{ $value->total_seats }}</td>
                          <td>{{ $value->fare }}</td>
                          <td>
                              <a href="#" id="trip{{ $value->t_id }}" class="btn btn-default btn-sm" type="button" data-toggle="modal" data-target="#modal-seats{{ $value->t_id }}">View Seats</a>
                          </td>

                      </tr>
                      <span id="data"></span>
                      @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                      <th>Company name</th>
                      <th>Departure Time</th>
                      <th>Seats Available</th>
                      <th>Fare</th>
                      <th>Action</th>
                  </tr>
                  </tfoot>
                </table>


                <!--edit modal-->
                 @foreach ($search_details as $value)
                    <div class="modal fade" id="modal-seats{{ $value->t_id }}" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-xl">
                            <form action="{{ url('/bus/booking') }}" method="post">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Choose your seat(s)</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <span id="info" class="px-5">Hold the cursor on seats for seat numbers, click to select or deselect.</span>
                                                <div class="seats-layout">
                                                    <div class="row">
                                                        <i class="far fa-user ml-auto" data-toggle='tooltip' data-placement='bottom' data-original-title="Driver" ></i>
                                                    </div>
                                                    <div class="row" id="seats{{ $value->t_id }}"> </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="input-group col-md-4">
                                                        <input type="checkbox" name="" value=""  id="seatsInfo">
                                                        <label for="">Available</label>
                                                    </div>
                                                    <div class="input-group col-md-4">
                                                        <input type="checkbox" name="" value="" id="seatsInfo" checked >
                                                        <label for="">Selected</label>
                                                    </div>
                                                    <div class="input-group col-md-4">
                                                        <input type="checkbox" name="" value="" id="seatsInfo" checked disabled>
                                                        <label for="">Booked</label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <table class="table table-striped" >
                                                        <thead>
                                                            <tr>
                                                                <th>Seats</th>
                                                                <th>Fare</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="seatsTable{{ $value->t_id }}">

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="row">
                                                    <p><strong>Total:</strong> <span id="totalCost{{ $value->t_id }}"></span></p>
                                                    <input type="hidden" name="total" id="total{{ $value->t_id }}" value="">
                                                    <input type="hidden" name="trip_id" value="{{ $value->t_id }}">
                                                </div>
                                                <div class="row">
                                                    <label for="">Choose your boarding point <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="boarding_point">
                                                        {{-- <option value="">--select one--</option> --}}
                                                        <option value="">{{ $value->company_name.' bus counter, '.$value->start_name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <input type="submit" class="btn btn-primary" name="" value="Continue">
                                    </div>
                                </div>
                            <!-- /.modal-content -->
                            </form>
                        </div>
                    <!-- /.modal-dialog -->
                    </div>
                     @endforeach
                <!--modal-->
            </div>
        </div>
    </div>

<!--SEARCH-BAR-END-->

@endsection

@section('public_css')

    <style media="screen">
            .seats-layout {
               width: 50%;
               margin: auto;
               border: 1px solid;
               padding: 20px 42px;
           }

           .seats-layout input.checkbox, #seatsInfo {
               width: 30px;
               height: 20px;
               margin: 5px 10px;
               cursor: pointer;
           }

           input[type=checkbox]:nth-child(2) {
               /* margin-right: 50px; */
           }

           .seats-layout i {
               margin: 20px;
               margin-right: 14px;
               font-size: 20px;
           }
           #info{
               font-size:13px;
           }
           #seatsTable{
               min-height: 100px;
           }
    </style>
@endsection



@section('public_scripts')
    <script type="text/javascript">

$(document).ready(function(){


 @foreach ($search_details as $value)
// ====================================================================
    //seats manage
// ====================================================================

    $('#trip{{ $value->t_id }}').click(function(){

        var trip_id = {{ $value->t_id }};
        var returnedData;

        $.ajax({
           type:'GET',
           url:'/seat_allocations',
           // dataType: 'json',
           data:{trip_id:trip_id},
           success:function(data){

              returnedData = data.success;
              doSomething(returnedData);
           }
       });

       function doSomething(param) {
           var output='';
          for (var i = 0; i < param.length; i++) {
            if (param[i].seat_status == 2) {
                output +="<input type='checkbox' disabled checked data-toggle='tooltip' name=seats[] data-placement='bottom' data-original-title="+ param[i].seat_number +" value= "+ param[i].seat_number +" class='checkbox' />";
            }else{
            output +="<input type='checkbox' data-toggle='tooltip' name=seats[] data-placement='bottom' data-original-title="+ param[i].seat_number + " value= " + param[i].seat_number +" class='checkbox' />";
            }
           }
           output += '';

            $('#seats{{ $value->t_id }}').html(output);

            $(function () {
                   $("input[data-toggle='tooltip']").tooltip();
               });

               $('#seats{{ $value->t_id }} input.checkbox').click( function() {
                       var count=0;
                        if($(this).is(":checked")){
                            var value = $(this).val();
                           $("#seatsTable{{ $value->t_id }}").append("<tr><td id='seatNumber'>"+value+"</td><td>{{ $value->fare }}</td></tr>");
                           count = $( "#seatsTable{{ $value->t_id }} tr" ).length;
                       }else if($(this).is(":not(:checked)")){
                           var value = $(this).val();
                           $("td").filter(function() {
                               return $(this).text() == value;
                           }).closest("tr").remove();
                           count = $( "#seatsTable{{ $value->t_id }} tr" ).length ;
                       }
                       var totalCost = {{ $value->fare }}*count;
                       $('#totalCost{{ $value->t_id }}').text(totalCost);
                       $('#total{{ $value->t_id }}').val(totalCost);
                   });
        }

    });
    @endforeach

});




// $(document).on('change',function(){
//
//
//     $(function () {
//         $("input[data-toggle='tooltip']").tooltip();
//     });
//
//
// // ====================================================================
//     //seats selections
// // ====================================================================
//     $('#seats input.checkbox').click( function() {
//         var count=0;
//         //alert('hi');
//          if($(this).is(":checked")){
//              var value = $(this).val();
//             $("#seatsTable").append("<tr><td id='seatNumber'>"+value+"</td><td>{{ $value->fare }}</td></tr>");
//             count = $( "#seatsTable tr" ).length;
//         }else if($(this).is(":not(:checked)")){
//             var value = $(this).val();
//             $("td").filter(function() {
//                 return $(this).text() == value;
//             }).closest("tr").remove();
//             count = $( "#seatsTable tr" ).length ;
//         }
//         var totalCost = {{ $value->fare }}*count;
//         $('#totalCost').text(totalCost);
//         $('#total').val(totalCost);
//     });
//
//
// });
    </script>
@endsection

@extends('layouts.public')
@section('content')

    {{-- @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}

    @if (session()->has('message'))
        <div class="alert alert-{{ session('type') }}">
            {{ session('message') }}
        </div>
    @endif


<!--SEARCH-BAR-->
    <div class="container">
        <div class="row my-5">
            <div class="col-md-6">
                <form class="" action="{{ url('/bus/search') }}" method="post">
                    @csrf
                    <h1>Bus tickets booking</h1>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="from">From</label> <span class="text-danger">*</span>
                            <select class="form-control select2 @error('from') is-invalid @enderror" id="from" name="from" placeholder="Select Destination">
                                <option value="">--Select One--</option>
                                @foreach ($tripsInfo as $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                            @error('from')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                            <label for="to">To</label> <span class="text-danger">*</span>
                            <select class="form-control select2 @error('to') is-invalid @enderror" id="to" name="to" placeholder="Select Destination">
                                <option value="">--Select One--</option>
                                @foreach ($tripsInfo as $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                            @error('to')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                            <label for="date1" >Date of Journey</label> <span class="text-danger">*</span>
                                <input type="text" name="date_of_journey" class="form-control @error('date_of_journey') is-invalid @enderror" id="date1" readonly placeholder="Select Date of journey..">
                                @error('date_of_journey')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                            <label for="date2">Date of Return</label> <span class="text-muted">(optional)</span>
                                <input type="text" name="date_of_return" class="form-control" readonly id="date2">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 pb-2">
                            <button type="button" class="btn btn-sm btn-primary col-sm-12" id="reset">Reset Dates</button>
                        </div>
                        <div class="col-md-6">
                            <input type="submit" class="btn btn-sm btn-primary col-sm-12" name="" value="Search Buses">
                        </div>
                    </div>

                </form>
            </div>
            <div class="col-md-6 px-5">
                <img src="images/bus.png" class="img-fluid">
            </div>
        </div>
    </div>

<!--SEARCH-BAR-END-->

<!--ALL AVAILABLE ROUTES-->
    <div class="container">
        <div class="row border border-secondary rounded pt-2">
            <div class="col-12">
                <div class="text-center">
                    <h4>All Available Routes</h4>
                </div>
            </div>
        </div>
        <div class="row py-3">
            @if (count($allRoutes)>0)
                <ul>
                    @foreach ($allRoutes as $value)
                        <li>{{ $value->start_name . ' - ' . $value->end_name}}</li>
                    @endforeach

                </ul>
            @else
                {{-- <p class=""></p> --}}
                <p class="blink"><span>No available trips found!!</span></p>
            @endif

        </div>
    </div>
<!--ALL AVAILABLE ROUTES ENDS-->
@endsection


@section('public_css')
    <style media="screen">

    .blink{
    		width:200px;
    		height: 50px;
    		text-align: center;
    	}
    .blink span{
    		font-size: 18px;
    		font-family: cursive;
    		color: #333;
    		animation: blink 1s linear infinite;
    	}
    @keyframes blink{
    0%{opacity: 0;}
    50%{opacity: .5;}
    100%{opacity: 1;}
    }

</style>
@endsection
@section('public_scripts')
    <script type="text/javascript">
        $('#date1').datepicker({
            dateFormat: "yy-m-d",
            minDate: new Date(),
        });
        $('#date2').datepicker({
            dateFormat: "yy-m-d",
            minDate: new Date(),
        });

        $('#reset').click(function(){
            $('#from').val('');
            $('#to').val('');
            $('#date1').datepicker('setDate', null);
        });

    </script>

@endsection

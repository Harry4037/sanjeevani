@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <div style="display: none;" class="alert msg" role="alert"></div>
                <h2>User Booking</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form class="form-horizontal form-label-left" action="#" method="post" id="BookingForm">
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Select User</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="user" name="user">
                                <option value="">Choose option</option>
                                @if($users)
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->mobile_number." (". $user->user_name.")"  }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <div style="display: none;" class="alert msg" role="alert">
                </div>
                <h2>Bookings</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="list" class="table table-striped table-bordered table-responsive text-center">
                    <thead>
                        <tr>
                            <th>Sr.No.</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Package Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</div>

@endsection

@section('script')
<script>
    $(document).ready(function () {
    
    });
</script>
@endsection
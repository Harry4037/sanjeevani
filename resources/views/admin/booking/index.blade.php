@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <div style="display: none;" class="alert msg" role="alert"></div>
                <h2>User Booking</h2>
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('admin.booking.create') }}">Create New Booking</a>
                </div>
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
                            <th>Resort Name</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Package Name</th>
                            <th>Status</th>
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
            var t = $('#list').DataTable({
            lengthMenu: [[5, 10, 25, 50], [5, 10, 25, 50]],
            // searching: true,
            processing: true,
            serverSide: true,
            ajax: _baseUrl + "/admin/booking/booking-list/0",
            "columns": [
                {"data": null,
                    sortable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {"data": "resort"},
                {"data": "check_in"},
                {"data": "check_out"},
                {"data": "package"},
                {"data": null,
                    sortable: false,
                    render: function (data, type, row, meta) {
                        return row['status'];
                    }
                },
            ]
        });

        $(document).on("change","#user", function(){
            var record_id = $("#user :selected").val();
            t.ajax.url(_baseUrl + "/admin/booking/booking-list/"+record_id).load();
        });
    });
</script>
@endsection
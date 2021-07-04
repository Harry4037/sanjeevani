@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <div style="display: none;" class="alert msg" role="alert">
                </div>
                <h2>Bookings ({{ $user->user_name }})</h2>
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('admin.users.booking-create', $user->id) }}">Create Booking</a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="list" class="table table-striped table-bordered table-responsive text-center">
                    <thead>
                        <tr>
                            <th>Sr.No.</th>
                            <th>Source Name</th>
                            <th>Source Id</th>
                            <th>Resort Name</th>
                            <th>Room No.</th>
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
    var t = $('#list').DataTable({
    lengthMenu: [[10, 25, 50], [10, 25, 50]],
            // searching: true,
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax: _baseUrl + "/admin/user-booking-list/" + {{ $user->id }},
            "columns": [
            {"data": null,
                    sortable: false,
                    render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
            },
            {"data": "source_name","sortable": false},
            {"data": "source_id","sortable": false},
            {"data": "resort","sortable": false},
            {"data": "room_no","sortable": false},
            {"data": "check_in","sortable": false},
            {"data": "check_out","sortable": false},
            {"data": "package","sortable": false},
            {"data": null,
                    sortable: false,
                    render: function (data, type, row, meta) {
                    return row['status'];
                    }
            },
            {"data": "action",
                    "sortable": false,
            }
            ]
    });
    $(document).on("change", "#user", function(){
    var record_id = $("#user :selected").val();
    t.ajax.url(_baseUrl + "/admin/booking/booking-list/" + record_id).load();
    });
    });
</script>
@endsection
@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <div style="display: none;" class="alert msg" role="alert">
                </div>
                <h2>SOS Management</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="list" class="table table-striped table-bordered table-responsive text-center">
                    <thead>
                        <tr>
                            <th>Sr.No.</th>
                            <th>User Name</th>
                            <th>Resort</th>
                            <th>Room Type</th>
                            <th>Room No.</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
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
            searching: true,
            processing: true,
            serverSide: true,
            ajax: _baseUrl + "/admin/sos/sos-list",
            "columns": [
                {"data": null,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {"data": "user_name"},
                {"data": "resort_name"},
                {"data": "room_type"},
                {"data": "room_no"},
                {"data": "latitude"},
                {"data": "longitude"},
                // {"data": "action", sortable: false, },
            ]
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        
    });
</script>
@endsection
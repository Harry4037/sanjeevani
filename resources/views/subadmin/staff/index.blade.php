@extends('layouts.subadmin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <h2>Staff</h2>
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('subadmin.staff.add') }}">Add Staff</a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="list" class="table table-striped table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Sr.No.</th>
                            <th>Name</th>
                            <th>EmailAddress</th>
                            <th>PhoneNo.</th>
                            <th>Duty Status</th>
                            <!--<th>Resort Name</th>-->
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

@endsection

@section('script')
<script>
    $(document).ready(function () {
        var t = $('#list').DataTable({
            lengthMenu: [[10, 25, 50], [10, 25, 50]],
            searching: true,
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax: _baseUrl + "/sub-admin/staff/staff-list",
            "columns": [
                {"data": null,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {"data": "name", sortable: false},
                {"data": "email", sortable: false},
                {"data": "mobileno", sortable: false},
                {"data": "is_push_on", sortable: false,
                    render: function (data, type, row, meta) {
//                        var status = '';
//                        if (row['is_push_on'] == 1) {
//                            status = "<button type='button' class='btn btn-xs btn-round btn-success'>On Duty</button>";
//                        } else {
//                            status = "<button type='button' class='btn btn-xs btn-round btn-danger'>Off Duty</button>";
//                        }
                        return row['is_push_on'];
                    }
                },
//                {"data": "resort_name"},
                {"data": null,
                    sortable: false,
                    render: function (data, type, row, meta) {
                        return row['status'];
                    }
                },
                {"data": null,
                    sortable: false,
                    render: function (data, type, row, meta) {
                        return row['view-deatil'];
                    }
                },
            ]
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on("click", ".user_status", function () {

            var record_id = this.id;
            var th = $(this);
            var status = th.attr('data-status');
            var update_status = (status == '1') ? 0 : 1;
            $.ajax({
                url: _baseUrl + '/sub-admin/staff/staff-status',
                type: 'post',
                data: {status: update_status, record_id: record_id},
                dataType: 'json',
                success: function (res) {

                    if (res.status)
                    {
                        th.attr('data-status', res.data.status);
                        $(".msg").addClass("alert-success");
                        $(".msg").html(res.data.message);
                        $(".msg").css("display", "block");
                        setTimeout(function () {
                            $(".msg").fadeOut();
                        }, 5000);
                    }
                }
            });

        });

        $(document).on("click", ".duty_status", function () {

            var record_id = this.id;
            var th = $(this);
            var status = th.attr('data-status');
            var update_status = (status == '1') ? 0 : 1;
            $.ajax({
                url: _baseUrl + '/sub-admin/staff/staff-duty-status',
                type: 'post',
                data: {status: update_status, record_id: record_id},
                dataType: 'json',
                beforeSend: function () {
                    $(".overlay").show();
                },
                success: function (res) {

                    if (res.status)
                    {
                        th.attr('data-status', res.data.status);
                        showSuccessMessage(res.data.message);
                        $(".overlay").hide();
                    } else {
                        showErrorMessage(res.message);
                        $(".overlay").hide();
                    }
                }
            });

        });
    });
</script>
@endsection

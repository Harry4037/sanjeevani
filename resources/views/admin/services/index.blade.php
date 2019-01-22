@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
<!--                <div style="display: none;" class="alert msg" role="alert">
                </div>-->
                <h2>Services Management</h2>
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('admin.service.add') }}">Add Service</a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="list" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Sr.No.</th>
                            <th>Service Icon</th>
                            <th>Service Name</th>
                            <th>Service Type</th>
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
            lengthMenu: [[5, 10, 25, 50], [5, 10, 25, 50]],
            searching: true,
            processing: true,
            serverSide: true,
            ajax: _baseUrl + "/admin/services-list",
            "columns": [
                {"data": null,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {"data": "icon", sortable: false},
                {"data": "name"},
                {"data": "type"},
                {"data": null,
                    sortable: false,
                    render: function (data, type, row, meta) {
                        return row['status'];
                    }
                },
                {"data": "action", sortable: false},
            ]
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on("click", ".service_status", function () {

            var record_id = this.id;
            var th = $(this);
            var status = th.attr('data-status');
            var update_status = (status == '1') ? 0 : 1;
            $.ajax({
                url: _baseUrl + '/admin/service-status',
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

        $(document).on("click", ".delete", function () {
            var record_id = this.id;
            bootbox.confirm("Are you sure want to delete this service?", function (result) {
                if (result) {
                    $.ajax({
                        url: _baseUrl + '/admin/services/delete',
                        type: 'post',
                        data: {id: record_id},
                        dataType: 'json',
                        success: function (res) {
                            if (res.status)
                            {
                                t.draw();
                            } else {
                                alert("something went be wrong.")
                            }
                        }
                    });
                }
            });
        });
    });
</script>
@endsection

@extends('layouts.subadmin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <h2>Services Management</h2>
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('subadmin.service.add') }}">Add Service</a>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">
                <table id="list" class="table table-striped table-bordered text-center">
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
            lengthMenu: [[10, 25, 50], [10, 25, 50]],
            searching: true,
            processing: true,
            serverSide: true,
            stateSave: true,
            language: {
                'loadingRecords': '&nbsp;',
                'processing': '<i class="fa fa-refresh fa-spin"></i>'
            },
            ajax: {
                url: _baseUrl + "/sub-admin/services-list",
                error: function (xhr, error, thrown) {
                    showErrorMessage(error);
                },
            },
            "columns": [
                {"data": null,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {"data": "icon", sortable: false},
                {"data": "name", sortable: false},
                {"data": "type", sortable: false},
                {"data": null,
                    sortable: false,
                    render: function (data, type, row, meta) {
                        return row['status'];
                    }
                },
                {"data": "action", sortable: false},
            ]
        });

        $(document).on("click", ".service_status", function () {
            try {
                var record_id = this.id;
                var th = $(this);
                var status = th.attr('data-status');
                var update_status = (status == '1') ? 0 : 1;
                $.ajax({
                    url: _baseUrl + '/sub-admin/service-status',
                    type: 'post',
                    beforeSend: function () {
                        $(".overlay").show();
                    },
                    data: {status: update_status, record_id: record_id},
                    dataType: 'json',
                    success: function (res) {

                        if (res.status)
                        {
                            th.attr('data-status', res.data.status);
                            showSuccessMessage(res.data.message);
                        } else {
                            showErrorMessage(res.message);
                        }
                        $(".overlay").hide();
                    }
                });
            } catch (err) {
                showErrorMessage(err.message);
                $(".overlay").hide();
            }

        });

        $(document).on("click", ".delete", function () {
            var record_id = this.id;
            bootbox.confirm("Are you sure want to delete this service?", function (result) {
                try {
                    if (result) {
                        $.ajax({
                            url: _baseUrl + '/sub-admin/services/delete',
                            type: 'post',
                            data: {id: record_id},
                            dataType: 'json',
                            beforeSend: function () {
                                $(".overlay").show();
                            },
                            success: function (res) {
                                if (res.status)
                                {
                                    t.draw();
                                    showSuccessMessage(res.message);
                                } else {
                                    showErrorMessage(res.message);
                                }
                                $(".overlay").hide();
                            }
                        });
                    }
                } catch (err) {
                    showErrorMessage(err.message);
                    $(".overlay").hide();
                }
            });
        });
    });
</script>
@endsection

@extends('layouts.subadmin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <h2>Meal Management</h2>
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('subadmin.meal.add') }}">Add Meal</a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="list" class="table table-striped table-bordered table-responsive text-center">
                    <thead>
                        <tr>
                            <th>Sr.No.</th>
                            <th>Image</th>
                            <th>Name</th>
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
            lengthMenu: [[5, 10, 25, 50], [5, 10, 25, 50]],
            searching: true,
            processing: true,
            serverSide: true,
            language: {
                'loadingRecords': '&nbsp;',
                'processing': '<i class="fa fa-refresh fa-spin"></i>'
            },
            ajax: {
                url: _baseUrl + "/sub-admin/meal/list",
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
                {"data": "image", sortable: false, },
                {"data": "name"},
                {"data": null,
                    sortable: false,
                    render: function (data, type, row, meta) {
                        return row['status'];
                    }
                },
                {"data": "action", sortable: false, },
            ]
        });

        $(document).on("click", ".meal_status", function () {
            try {
                var record_id = this.id;
                var th = $(this);
                var status = th.attr('data-status');
                var update_status = (status == '1') ? 0 : 1;
                $.ajax({
                    url: _baseUrl + '/sub-admin/meal/update-status',
                    type: 'post',
                    data: {status: update_status, record_id: record_id},
                    dataType: 'json',
                    beforeSend: function () {
                        $(".overlay").show();
                    },
                    success: function (res) {
                        if (res.status) {
                            th.attr('data-status', res.data.status);
                            showSuccessMessage(res.data.message);
                        } else {
                            showSuccessMessage(res.message);
                        }
                        $(".overlay").hide();
                    }
                });
            } catch (err) {
                showErrorMessage(err.message);
            }

        });

        $(document).on("click", ".delete", function () {
            var record_id = this.id;
            bootbox.confirm("Are you sure want to delete this meal item?", function (result) {
                if (result) {
                    try {
                        $.ajax({
                            url: _baseUrl + '/sub-admin/meal/delete',
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
                    } catch (err) {
                        showErrorMessage(err.message);
                    }
                }
            });
        });
    });
</script>
@endsection
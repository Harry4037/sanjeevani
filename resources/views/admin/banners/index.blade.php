@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <h2>Banner List</h2>
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('admin.banner.add') }}">Add Banner</a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="list" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Sr.No.</th>
                            <th>Banner</th>
                            <th>Resort Name</th>
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
            searching: false,
            processing: true,
            serverSide: true,
            language: {
                'loadingRecords': '&nbsp;',
                'processing': '<i class="fa fa-refresh fa-spin"></i>'
            },
            ajax: _baseUrl + "/admin/banners-list",
            "columns": [
                {"data": null,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {"data": "banner", sortable: false},
                {"data": "resort_name", sortable: false},
                {"data": null,
                    sortable: false,
                    render: function (data, type, row, meta) {
                        return row['status'];
                    }
                },
                {"data": "action", sortable: false},
            ]
        });


        $(document).on("click", ".banner_status", function () {

            var record_id = this.id;
            var th = $(this);
            var status = th.attr('data-status');
            var update_status = (status == '1') ? 0 : 1;
            $.ajax({
                url: _baseUrl + '/admin/banner-status',
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

        $(document).on("click", ".delete", function () {
            var record_id = this.id;
            bootbox.confirm("Are you sure want to delete this banner?", function (result) {
                if (result) {
                    $.ajax({
                        url: _baseUrl + '/admin/banner/delete',
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
                                $(".overlay").hide();
                                showSuccessMessage(res.message);
                            } else {
                                $(".overlay").hide();
                                showErrorMessage(res.message);
                            }
                        }
                    });
                }
            });
        });
    });
</script>

@endsection
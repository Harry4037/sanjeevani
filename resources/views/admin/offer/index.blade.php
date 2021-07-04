@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <h2>Offers Management</h2>
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('admin.offer.add') }}">Add Offer</a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="list" class="table table-striped table-bordered table-responsive text-center">
                    <thead>
                        <tr>
                            <th>Sr.No.</th>
                            <th>Image</th>
                            <th>Offer Name</th>
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
            searching: true,
            processing: true,
            serverSide: true,
            stateSave: true,
            language: {
                'loadingRecords': '&nbsp;',
                'processing': '<i class="fa fa-refresh fa-spin"></i>'
            },
            ajax: _baseUrl + "/admin/offer/offer-list",
            "columns": [
                {"data": null,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {"data": "image", sortable: false, },
                {"data": "name", sortable: false},
                {"data": "resort_name", sortable: false},
                {"data": null,
                    sortable: false,
                    render: function (data, type, row, meta) {
                        return row['status'];
                    }
                },
                {"data": "action", sortable: false, },
            ]
        });

        $(document).on("click", ".offer_status", function () {
            var record_id = this.id;
            var th = $(this);
            var status = th.attr('data-status');
            var update_status = (status == '1') ? 0 : 1;
            $.ajax({
                url: _baseUrl + '/admin/offer/update-status',
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
            bootbox.confirm("Are you sure want to delete this offer?", function (result) {
                if (result) {
                    $.ajax({
                        url: _baseUrl + '/admin/offer/delete',
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
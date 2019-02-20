@extends('layouts.subadmin.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <h2>Order</h2>
                <div class="pull-right">

                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="list" class="table table-striped table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Sr.No.</th>
                            <th>User Name</th>
                            <th>Invoice Id</th>
                            <th>Total Amount</th>
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
            lengthMenu: [[15, 25, 50], [15, 25, 50]],
            searching: true,
            processing: true,
            serverSide: true,
            stateSave: true,
            language: {
                'loadingRecords': '&nbsp;',
                'processing': '<i class="fa fa-refresh fa-spin"></i>'
            },
            ajax: {
                url: _baseUrl + "/sub-admin/order/list",
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
                {"data": "user_name", sortable: false},
                {"data": "invoice_id", sortable: false},
                {"data": "total_amount", sortable: false},
                {"data": "status", sortable: false},
                {"data": "action", sortable: false},
            ]
        });
    });
</script>
@endsection

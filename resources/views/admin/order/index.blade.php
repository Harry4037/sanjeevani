@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <div style="display: none;" class="alert msg" role="alert">
                </div>
                <h2>Order</h2>
                <div class="pull-right">

                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="list" class="table table-striped table-bordered text-center">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>
                                <select class="form-control custom_search" id="o_status">
                                    <option value="">--SELECT OPTION--</option>
                                    <option value="1">NEW</option>
                                    <option value="2">ACCEPTED BY STAFF</option>
                                    <option value="3">UNDER APPROVAL</option>
                                    <option value="4">COMPLETED</option>
                                    <option value="5">REJECTED</option>
                                </select>
                            </th>
                            <th></th>
                        </tr>
                        <tr>
                            <th>Sr.No.</th>
                            <th>User Name</th>
                            <th>Room No.</th>
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

    var url = site_url + "/order/list";
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
        ajax: url,
        "columns": [
            {"data": null,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {"data": "user_name", sortable: false},
            {"data": "room_no", sortable: false},
            {"data": "invoice_id", sortable: false},
            {"data": "total_amount", sortable: false},
            {"data": "status", sortable: false},
            {"data": "action", sortable: false},
        ]
    });

    $(document).ready(function () {
        $(document).on('keyup change clean', '.custom_search', function () {
            var o_status = $("#o_status").val();

            var new_url = url + "?";
            new_url += "o_status=" + o_status;
            var finalUri = new_url;
            t.ajax.url(finalUri).load();
        });
    });
</script>
@endsection

@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
<!--                <div style="display: none;" class="alert msg" role="alert">
                </div>-->
                <h2>Nearby Place Management</h2>
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('admin.nearby.add') }}">Add Nearby</a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="list" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Sr.No.</th>
                            <th>Nearby Name</th>
                            <th>Distance</th>
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
            lengthMenu: [[5, 10, 25, 50], [5, 10, 25, 50]],
            searching: true,
//            ordering: true,
            processing: true,
            serverSide: true,
            language: {
                'loadingRecords': '&nbsp;',
                'processing': '<i class="fa fa-refresh fa-spin"></i>'
            },
            ajax: _baseUrl + "/admin/nearby/nearby-list/",
            "columns": [
                {"data": null,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {"data": "name"},
                {"data": "distance"},
                {"data": "resort_name"},
                {"data": null,
                    sortable: false,
                    render: function (data, type, row, meta) {
                        return row['status'];
                    }
                },
                {"data": "action"},
            ]
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).on("click", ".nearby_status", function () {
            var record_id = this.id;
            var th = $(this);
            var status = th.attr('data-status');
            var update_status = (status == '1') ? 0 : 1;
            $.ajax({
                url: _baseUrl + '/admin/nearby/update-status',
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
                        $(".msg").addClass("alert-success");
                        $(".msg").html(res.data.message);
                        $(".msg").css("display", "block");
                        setTimeout(function () {
                            $(".msg").fadeOut();
                        }, 2000);
                        $(".overlay").hide();
                    }
                }
            });
        });

        $(document).on("click", ".delete", function () {
            var record_id = this.id;
            bootbox.confirm("Are you sure want to delete this nearby?", function (result) {
                if (result) {
                    $.ajax({
                        url: _baseUrl + '/admin/nearby/delete',
                        type: 'post',
                        data: {id: record_id},
                        dataType: 'json',
                        beforeSend: function () {
                            $(".overlay").show();
                        },
                        success: function (res) {

                            if (res.status)
                            {
                                $(".overlay").hide();
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

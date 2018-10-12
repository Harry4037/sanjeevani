$(document).ready(function () {
    var t = $('#list').DataTable({
        lengthMenu: [[5, 10, 25, 50], [5, 10, 25, 50]],
        searching: true,
        ordering: true,
        processing: true,
//        serverSide: true,
        ajax: _baseUrl + "/admin/users-list",
        "columns": [
            {"data": null,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {"data": "name", sortable: true},
            {"data": "email", sortable: true},
            {"data": "mobileno", sortable: true},
            {"data": null,
                sortable: false,
                render: function (data, type, row, meta) {
                    return row['status'];
                }
            },
            {"data": null,
                sortable: false,
                render: function (data, type, row, meta) {
                    var url = row['view-deatil'];
                    return "<a class='btn btn-info' href='"+url+"'>view</>";
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
            url: _baseUrl + '/admin/user-status',
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
});
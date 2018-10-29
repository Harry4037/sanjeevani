$(document).ready(function () {
    var t = $('#list').DataTable({
        lengthMenu: [[5, 10, 25, 50], [5, 10, 25, 50]],
        searching: true,
        ordering: true,
        processing: true,
//        serverSide: true,
        ajax: _baseUrl + "/admin/banners-list",
        "columns": [
            {"data": null,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {"data": "banner"},
            {"data": null,
                sortable: false,
                render: function (data, type, row, meta) {
                    return row['status'];
                }
            },
        ]
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
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

    $("#addBannerForm").validate({
        rules: {
            banner_image: {
                required: true
            },
            banner_status: {
                required: true
            }
        }
    });
});
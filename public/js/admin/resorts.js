$(document).ready(function () {

    var t = $('#list').DataTable({
        lengthMenu: [[5, 10, 25, 50], [5, 10, 25, 50]],
        searching: true,
        ordering: true,
        processing: true,
//        serverSide: true,
        ajax: _baseUrl + "/admin/resort/resorts-list",
        "columns": [
            {"data": null,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {"data": "name"},
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

    $(document).on("click", ".resort_status", function () {
        var record_id = this.id;
        var th = $(this);
        var status = th.attr('data-status');
        var update_status = (status == '1') ? 0 : 1;
        $.ajax({
            url: _baseUrl + '/admin/resort/update-status',
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

    $("#addResortForm").validate({
        rules: {
            resort_name: {
                required: true
            },
            contact_no: {
                required: true
            },
            room_types: {
                required: true
            },
            resort_description: {
                required: true
            },
            address: {
                required: true
            },
            pin_code: {
                required: true
            },
            state: {
                required: true
            },
            district: {
                required: true
            },
            city: {
                required: true
            },
            city: {
                required: true
            },
        }
    });


    Dropzone.options.myDropzone = {
        init: function () {
            this.on("success", function (file, response) {
                if (response.status) {
                    var removeButton = Dropzone.createElement("<button id='" + response.id + "'>Remove file</button>");
                    var _this = this;
                    removeButton.addEventListener("click", function (e) {
                        // Make sure the button click doesn't submit the form:
                        e.preventDefault();
                        e.stopPropagation();

                        // If you want to the delete the file on the server as well,
                        // you can do the AJAX request here.
                        var record_id = this.id;
                        if (record_id > 0) {
                            $.ajax({
                                url: _baseUrl + '/admin/resort/delete-images',
                                type: 'post',
                                data: {record_id: record_id},
                                success: function (res) {
                                    // Remove the file preview.
                                    _this.removeFile(file);
                                }
                            });
                        }
                    });
                    file.previewElement.appendChild(removeButton);
                }
            });
        }
    };

});

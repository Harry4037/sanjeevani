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
            {"data": "contact_no"},
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
                required: true,
                number: true
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
            
        }
    });
    
    $("#editResortForm").validate({
        rules: {
            edit_resort_name: {
                required: true
            },
            edit_contact_no: {
                required: true,
                number: true
            },
            edit_room_types: {
                required: true
            },
            edit_resort_description: {
                required: true
            },
            edit_address: {
                required: true
            },
            edit_pin_code: {
                required: true
            },
            edit_state: {
                required: true
            },
            edit_district: {
                required: true
            },
            edit_city: {
                required: true
            }
        }
    });

    Dropzone.options.myDropzone = {
        init: function () {
            this.on("success", function (file, response) {
                if (response.status) {
                    var removeButton = Dropzone.createElement("<button style='margin-left: 22px;' class='btn btn-info btn-xs' id='" + response.id + "'>Remove file</button>");
                    var hidden_image_html = "<input id='resort_image_input_"+ response.file_name +"' type='hidden' name='resort_images[]' value='"+ response.file_name +"'>";
                    var _this = this;
                    removeButton.addEventListener("click", function (e) {
                        // Make sure the button click doesn't submit the form:
                        e.preventDefault();
                        e.stopPropagation();
                        var record_id = this.id;
                        $("#resort_image_input_"+record_id).remove();
                        _this.removeFile(file);
                        
                    });
                    file.previewElement.appendChild(removeButton);
                    $("#resort_images_div").append(hidden_image_html);
                }
            });
        }
    };

});

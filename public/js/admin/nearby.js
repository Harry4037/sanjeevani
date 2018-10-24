$(document).ready(function () {
    
    var t = $('#list').DataTable({
        lengthMenu: [[5, 10, 25, 50], [5, 10, 25, 50]],
        searching: true,
        ordering: true,
        processing: true,
//        serverSide: true,
        ajax: _baseUrl + "/admin/nearby/nearby-list/"+resort_id,
        "columns": [
            {"data": null,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {"data": "name"},
            {"data": "distance"},
            {"data": null,
                sortable: false,
                render: function (data, type, row, meta) {
                    return row['status'];
                }
            },
            {"data": "action"},
        ]
    });


});

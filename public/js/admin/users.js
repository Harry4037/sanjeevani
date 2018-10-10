$(document).ready(function () {
    var t = $('#list').DataTable({
        lengthMenu: [[5, 10, 25, 50], [5, 10, 25, 50]],
        searching: true,
        processing: true,
        serverSide: true,
        ajax: _baseUrl + "/admin/users-list",
        "columns": [
            {"data": null,
                sortable: false,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {"data": "name",sortable: true},
            {"data": "email"},
            {"data": "mobileno"},
            {"data": null,
                sortable: false,
                render: function (data, type, row, meta) {
                    return "hi";
                }
            },
        ]
    });
});
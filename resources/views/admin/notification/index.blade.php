@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <h2>Send Notification</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form class="form-horizontal form-label-left" action="{{ route('admin.notification.send') }}" method="post" id="sendNotificationForm">
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Select option</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="user_type" name="user_type">
                                <option value="">Choose option</option>
                                <option value="1">All User's</option>
                                <option value="2">Selected User's</option>
                                <option value="3">Active User's</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="display:none;" id="users_list_div">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Users</label>
                        <div class="col-md-6 col-sm-6 col-xs-12" id="users_list" style="overflow-y: scroll;height: 400px;">
                            <p style="padding: 5px;">
                                @foreach($users as $key => $user)
                            <div class="col-md-6 col-sm-6 col-xs-6" style="padding-bottom: 4px;">
                                <input class="flat" type="checkbox" name="notify_user[]" value="{{ $user->id }}"> 
                                @if(strlen($user->user_name) > 0)
                                <label>{{ $user->mobile_number.' ('.ucwords($user->user_name).')' }}</label>
                                @else
                                <label>{{ $user->mobile_number }}</label>
                                @endif
                            </div>

                            @endforeach
                            </p>
                            <span id="users_list_div_error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Title</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="title" placeholder="Title">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Message</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea  class="form-control" name="message" id="message" placeholder="Message"></textarea>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                            <button type="submit" class="btn btn-success">Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Notification List</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="list" class="table table-striped table-bordered table-responsive text-center">
                    <thead>
                        <tr>
                            <th>Sr.No.</th>
                            <th>Title</th>
                            <th>Message</th>
                            <th>Created At</th>
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
            ajax: _baseUrl + "/admin/notification/notifications-list",
            "columns": [
                {"data": null,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {"data": "title", sortable: false},
                {"data": "message", sortable: false},
                {"data": "created_at", sortable: false},
            ]
        });

        $(document).on("change", "#user_type", function () {
            var record_id = $("#user_type :selected").val();
            if (record_id == 2) {
                $("#users_list_div").css("display", "block");
            } else {
                $("#users_list_div").css("display", "none");
            }
        });

        $("#sendNotificationForm").validate({
            ignore: [],
            rules: {
                user_type: {
                    required: true
                },
                title: {
                    required: true,
                    maxlength: 50,
                },
                "notify_user[]": {
                    required: function () {
                        return $("#user_type").val() == 2
                    }
                },
                message: {
                    required: true,
                    maxlength: 100,
                },
            },

            errorPlacement: function (error, el) {
                if ($(el).attr('type') == 'checkbox') {
                    error.appendTo("#users_list_div_error");
                } else {
                    error.insertAfter(el);
                }
            },

            messages: {
                user_type: {
                    required: "Please select a user type."
                },
                title: {
                    required: "Please enter the title."
                },
                "notify_user[]": {
                    required: "Please select at least one user."
                },
                message: {
                    required: "Please enter the message."
                },
            },
            submitHandler: function (form) {

                let btn = $(form).find('button[type="submit"]');

                btn.text('Sending . . .').attr('disabled', 'disabled');

                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function (response) {
                        btn.text('Send').removeAttr('disabled');
                        t.draw();
                        if (response.status_code == 200) {
                            $(".msg").html(response.message);
                            $(".msg").removeClass("alert-danger");
                            $(".msg").addClass("alert-success");
                            $(".msg").css("display", "block");
                            $(form).get(0).reset();
                        } else {
                            $(".msg").html(response.message);
                            $(".msg").removeClass("alert-success");
                            $(".msg").addClass("alert-danger");
                            $(".msg").css("display", "block");
                        }

                        setTimeout(function () {
                            $(".msg").fadeOut();
                            location.reload();
                        }, 2000);
                    },

                    error: function () {
                        btn.text('Send').removeAttr('disabled');
                    }
                });
            }
        });

        if ($("input.flat")[0]) {
            $(document).ready(function () {
                $('input.flat').iCheck({
                    checkboxClass: 'icheckbox_flat-green',
                    radioClass: 'iradio_flat-green'
                });
            });
        }
    });

</script>
@endsection
@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <div style="display: none;" class="alert msg" role="alert"></div>
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
                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="display:none;" id="users_list_div">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Users</label>
                        <div class="col-md-6 col-sm-6 col-xs-12" id="users_list">

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
            </div>
        </div>
    </div>
</div>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function () {
        $(document).on("change", "#user_type", function () {
            var record_id = $("#user_type :selected").val();
            if (record_id == 2) {
                $.ajax({
                    url: _baseUrl + '/admin/notification/user-list',
                    type: 'get',
                    dataType: 'html',
                    success: function (res) {
                        $("#users_list").html(res);
                        $("#users_list_div").css("display", "block");
                    }
                });
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
                message: {
                    required: true
                },
            },
            submitHandler: function (form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function (response) {
                        if (response.status_code == 200) {
                            $(".msg").html(response.message);
                            $(".msg").removeClass("alert-danger");
                            $(".msg").addClass("alert-success");
                            $(".msg").css("display", "block");
                        } else {
                            $(".msg").html(response.message);
                            $(".msg").removeClass("alert-success");
                            $(".msg").addClass("alert-danger");
                            $(".msg").css("display", "block");
                        }
                        setTimeout(function () {
                            $(".msg").fadeOut();
                        }, 2000);
                    }
                });
            }
        });
    });
</script>
@endsection
@extends('layouts.subadmin.app')

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
                <form class="form-horizontal form-label-left" action="{{ route('subadmin.notification.send') }}" method="post" id="sendNotificationForm">
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
                            <p style="padding: 5px;">
                                @foreach($users as $key => $user)
                                <input class="flat" type="checkbox" name="notify_user[]" value="{{ $user->id }}"> 
                                {{ ucwords($user->user_name) }}
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
                    maxlength:50,
                },
                "notify_user[]":{
                    required:function(){
                        return $("#user_type").val() == 2
                    }
                },
                message: {
                    required: true,
                    maxlength:100,
                },
            },

            errorPlacement:function(error,el){
                if ($(el).attr('type') == 'checkbox') {
                    error.appendTo("#users_list_div_error");
                }else{
                    error.insertAfter(el);
                }
            },

            messages:{
                user_type:{
                    required:"Please select a user type."
                },
                title:{
                    required:"Please enter the title."
                },
                "notify_user[]":{
                    required:"Please select at least one user."
                },
                message:{
                    required:"Please enter the message."
                },
            },
            submitHandler: function (form) {

                let btn = $(form).find('button[type="submit"]');

                btn.text('Sending . . .').attr('disabled','disabled');

                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function (response) {
                        btn.text('Send').removeAttr('disabled');

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
                        }, 2000);
                    },

                    error:function(){
                        btn.text('Send').removeAttr('disabled');
                    }
                });
            }
        });
    });
</script>
@endsection
@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <div style="display: none;" class="alert msg" role="alert"></div>
                <h2>Change Password ({{ $user->user_name }})</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form class="form-horizontal form-label-left" action="{{ route('admin.subadmin.change-password', $user->id) }}" method="post" id="profileForm" >
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">old Password</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" type="password" name="old_password" id="old_password" placeholder="Old Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">New Password</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input  class="form-control" type="password" name="new_password" id="new_password" placeholder="New Password">

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Confirm Password</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input  class="form-control" type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password">

                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                            <a class="btn btn-default" href="{{ route("admin.subadmin.index") }}">Cancel</a>
                            <button type="submit" class="btn btn-success">Update</button>
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
        jQuery.validator.addMethod("alphanumeric", function (value, element) {
            return this.optional(element) || /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{6,20}$/.test(value);
        }, "Password must be <br> <ul><li>Minimum six character.</li><li>One uppercase letter.</li><li>One lowercase letter.</li><li>One numeric digit.</li><li>One special character.</li></ul>");

        $("#profileForm").validate({
            rules: {
                old_password: {
                    required: true
                },
                new_password: {
                    required: true,
                    alphanumeric: true
                },
                confirm_password: {
                    required: true,
                    equalTo: "#new_password"
                },
            },
            messages: {
                confirm_password: {
                    equalTo: "Confirm password does't match."
                },
            }
        });
    });
</script>
@endsection
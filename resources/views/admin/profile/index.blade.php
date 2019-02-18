@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <div style="display: none;" class="alert msg" role="alert"></div>
                <h2>Admin Profile</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form class="form-horizontal form-label-left" action="{{ route('admin.profile') }}" method="post" id="profileForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="record_id" id="record_id" value="{{ auth('admin')->user()->id }}" >
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">User Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ auth('admin')->user()->user_name }}" class="form-control" type="text" name="user_name" id="user_name" placeholder="User Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Email Id*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ auth('admin')->user()->email_id }}" class="form-control" type="text" name="email_id" id="email_id" placeholder="Email Address">
                            <small style="color:red;">Note: This email id is used for login into the system.</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Profile Pic</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" type="file" name="profile_pic" id="profile_pic" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Profile preview</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <img class="img-rounded" style="width: 100px; height: 100px;" src="{{ auth('admin')->user()->profile_pic_path }}" >
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                            <a class="btn btn-default" href="{{ route("admin.dashboard") }}">Cancel</a>
                            <button type="submit" class="btn btn-success">Submit</button>
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
        $("#profileForm").validate({
            rules: {
                email_id: {
                    required: true
                },
                profile_pic: {
                    accept: "image/*",
                },
            },
            messages: {
                profile_pic: {
                    accept: "Pleasae provide valid profile type.",
                },
            }
        });
    });
</script>
@endsection
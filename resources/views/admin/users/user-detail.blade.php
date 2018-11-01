@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>User Detail</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                    <div class="profile_img">
                        <div id="crop-avatar">
                            <!-- Current avatar -->
                            <img class="img-responsive avatar-view" src="{{ asset('img/img.jpg') }}" alt="Avatar" title="Change the avatar">
                        </div>
                    </div>
                    <h3>{{ $user->first_name.' '.$user->last_name }}</h3>

                    <ul class="list-unstyled user_data">
                        <li><i class="fa fa-envelope user-profile-icon"></i>
                            {{ $user->email_id }}<br>
                        </li>

                        <li>
                            <i class="fa fa-phone user-profile-icon"></i> {{ $user->mobile_number }}
                        </li>
                    </ul>
                    <div class="ln_solid"></div>
                    <div id="crop-avatar">
                        <!-- Current avatar -->
                        <img class="img-responsive avatar-view" src="{{ asset('img/img.jpg') }}" alt="Avatar" title="Change the avatar">
                    </div>
                    <div class="clearfix"></div>
                    <div id="crop-avatar">
                        <!-- Current avatar -->
                        <img class="img-responsive avatar-view" src="{{ asset('img/img.jpg') }}" alt="Avatar" title="Change the avatar">
                    </div>
                    <br />
                </div>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">General Details</label>
                    </div>
                    <div class="ln_solid"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

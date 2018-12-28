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
                            <img class="img-responsive avatar-view" src="{{ $user->profile_pic }}" alt="Avatar" title="Change the avatar">
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
                </div>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">Health Details</label>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="row">
                        <label class="col-md-1 col-sm-1 col-xs-6">Daibeties</label>
                        <div class="col-md-3 col-sm-3 col-xs-6">{{ isset($userHealth->is_diabeties) && $userHealth->is_diabeties ? "Yes" : "No" }}</div>
                        <label class="col-md-1 col-sm-1 col-xs-6">PP</label>
                        <div class="col-md-3 col-sm-3 col-xs-6">{{ isset($userHealth->is_ppa) && $userHealth->is_ppa ? "Yes" : "No" }}</div>
                        <label class="col-md-1 col-sm-1 col-xs-6">HBA1C</label>
                        <div class="col-md-3 col-sm-3 col-xs-6">{{ isset($userHealth->hba_1c) && $userHealth->hba_1c ? "Yes" : "No" }}</div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <label class="col-md-1 col-sm-1 col-xs-6">Fasting</label>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                            @if(isset($userHealth->fasting))
                            {{ $userHealth->fasting }}
                            @endif
                        </div>
                        <label class="col-md-1 col-sm-1 col-xs-6">BP</label>
                        <div class="col-md-2 col-sm-2 col-xs-6">
                            @if(isset($userHealth->bp))    
                            {{ $userHealth->bp }}
                            @endif
                        </div>
                        <label class="col-md-2 col-sm-2 col-xs-6">Insulin Dependency</label>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                            @if(isset($userHealth->insullin_dependency))    
                            {{ $userHealth->insullin_dependency }}
                            @endif
                        </div>
                    </div>
<!--                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-12">
                            <label class="col-4">Medical Document</label>
                            <img width="200" height="150" src="" class="img-rounded img-thumbnail">
                        </div>
                    </div>-->
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">Booking Details</label>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="row">
                        <label class="col-md-2 col-sm-2 col-xs-6">Source Name</label>
                        <div class="col-md-2 col-sm-2 col-xs-6">
                            @if(isset($userBooking->source_name))
                            {{ $userBooking->source_name }}
                            @endif
                        </div>
                        <label class="col-md-2 col-sm-2 col-xs-6">Source Id</label>
                        <div class="col-md-2 col-sm-2 col-xs-6">{{ $userBooking->source_id }}</div>
                        <!--                        <label class="col-m-2 col-sm-2 col-xs-6">HBA1C</label>
                                                <div class="col-md-2 col-sm-2 col-xs-6">{{ $userHealth->hba_1c ? "Yes" : "No" }}</div>-->
                    </div>
                    <div class="row">
                        <label class="col-md-2 col-sm-2 col-xs-6">Check In</label>
                        <div class="col-md-2 col-sm-2 col-xs-6">{{ $userBooking->check_in }}</div>
                        <label class="col-md-2 col-sm-2 col-xs-6">Check out</label>
                        <div class="col-md-2 col-sm-2 col-xs-6">{{ $userBooking->check_out }}</div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">Booking Details</label>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="row">
                        <label class="col-md-2 col-sm-2 col-xs-6">Source Name</label>
                        <div class="col-md-2 col-sm-2 col-xs-6">{{ $userBooking->source_name }}</div>
                        <label class="col-md-2 col-sm-2 col-xs-6">Source Id</label>
                        <div class="col-md-2 col-sm-2 col-xs-6">{{ $userBooking->source_id }}</div>
                        <!--                        <label class="col-m-2 col-sm-2 col-xs-6">HBA1C</label>
                                                <div class="col-md-2 col-sm-2 col-xs-6">{{ $userHealth->hba_1c ? "Yes" : "No" }}</div>-->
                    </div>
                    <div class="row">
                        <label class="col-md-2 col-sm-2 col-xs-6">Check In</label>
                        <div class="col-md-2 col-sm-2 col-xs-6">{{ $userBooking->check_in }}</div>
                        <label class="col-md-2 col-sm-2 col-xs-6">Check out</label>
                        <div class="col-md-2 col-sm-2 col-xs-6">{{ $userBooking->check_out }}</div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

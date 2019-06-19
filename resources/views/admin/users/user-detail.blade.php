@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>User Detail</h2>
                <div class="pull-right">
                    <a class="btn btn-info" href="{{ route('admin.users.index') }}">Back</a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                    <div class="profile_img">
                        <div id="crop-avatar">
                            <!-- Current avatar -->
                            <img style="height: 180px; width: 300px;" class="img-responsive avatar-view" src="{{ $user->profile_pic_path }}" alt="Avatar" title="Change the avatar">
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
                    <label>Aadhaar Id</label>
                    @if($user->aadhar_id)
                    <a target="_blank" href="{{ $user->aadhar_id }}"><img src="{{ $user->aadhar_id }}" class="img-rounded img-responsive" style="height: 200px; width: 500px;"></a>
                    @endif
                    @if($user->other_aadhar_id)
                    <a target="_blank" href="{{ $user->other_aadhar_id }}"><img src="{{ $user->other_aadhar_id }}" class="img-rounded img-responsive" style="height: 200px; width: 500px;"></a>
                    @endif
                    <label>Other Id</label>
                    @if($user->voter_id)
                    <a target="_blank" href="{{ $user->voter_id }}"><img src="{{ $user->voter_id }}" class="img-rounded img-responsive" style="height: 200px; width: 500px;"></a>
                    @endif
                </div>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    @if($userHealth)
                    <div class="panel panel-default">
                        <div class="panel-heading"><label>Health Details</label></div>
                        <div class="panel-body">
                            <div class="row">
                                <!--                                <div class="col-md-12">-->
                                <label class="col-md-3 col-sm-3 col-xs-6">Daibeties:</label>
                                <div class="col-md-3 col-sm-3 col-xs-6">{{ isset($userHealth->is_diabeties) && $userHealth->is_diabeties ? "Yes" : "No" }}</div>
                                <label class="col-md-3 col-sm-3 col-xs-6">PP:</label>
                                <div class="col-md-3 col-sm-3 col-xs-6">{{ isset($userHealth->is_ppa) && $userHealth->is_ppa ? "Yes" : "No" }}</div>
                                <!--</div>-->
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-sm-3 col-xs-6">HBA1C:</label>
                                <div class="col-md-3 col-sm-3 col-xs-6">{{ isset($userHealth->hba_1c) && $userHealth->hba_1c ? "Yes" : "No" }}</div>
                                <label class="col-md-3 col-sm-3 col-xs-6">Fasting:</label>
                                <div class="col-md-3 col-sm-3 col-xs-6">
                                    @if(isset($userHealth->fasting))
                                    {{ $userHealth->fasting }}
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-sm-3 col-xs-6">BP:</label>
                                <div class="col-md-3 col-sm-3 col-xs-6">
                                    @if(isset($userHealth->bp))    
                                    {{ $userHealth->bp }}
                                    @endif
                                </div>
                                <label class="col-md-3 col-sm-3 col-xs-6">Insulin Dependency:</label>
                                <div class="col-md-3 col-sm-3 col-xs-6">
                                    @if(isset($userHealth->insullin_dependency))    
                                    {{ $userHealth->insullin_dependency }}
                                    @endif
                                </div>
                            </div>
                            <div class="row" style="margin-top: 20px;">
                                <label class="col-md-2 col-sm-2 col-xs-6">Medical Document:</label>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    @if($userHealth->medical_documents) 
                                    <a target="_blank" href="{{ $userHealth->medical_documents }}" ><img src="{{ $userHealth->medical_documents }}" class="img-rounded img-responsive" style="height: 200px; width: 800px;"></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($userMembership)
                    <div class="panel panel-default">
                        <div class="panel-heading"><label>Membership Details:</label></div>
                        <div class="panel-body">
                            <div class="row">
                                <label class="col-md-3 col-sm-3 col-xs-6">Membership Id:</label>
                                <div class="col-md-3 col-sm-3 col-xs-6">
                                    @if(isset($userMembership->membership_id))
                                    {{ $userMembership->membership_id }}
                                    @endif
                                </div>
                                <label class="col-md-3 col-sm-3 col-xs-6">Valid From:</label>
                                <div class="col-md-3 col-sm-3 col-xs-6">
                                    @if(isset($userMembership->valid_from))    
                                    {{ date("d-m-Y h:i A", strtotime($userMembership->valid_from)) }}
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-sm-3 col-xs-6">Valid Till:</label>
                                <div class="col-md-3 col-sm-3 col-xs-6">
                                    @if(isset($userMembership->valid_till))    
                                    {{ date("d-m-Y h:i A", strtotime($userMembership->valid_till)) }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="panel panel-default">
                        <div class="panel-heading"><label>Booking Details</label></div>
                        <div class="panel-body">
                            @if($user->userBookingDetail != null)
                            <div class="row">
                                <label class="col-md-3 col-sm-3 col-xs-6">Booking Id:</label>
                                <div class="col-md-3 col-sm-3 col-xs-6">{{ isset($user->userBookingDetail->booking_id) ? $user->userBookingDetail->booking_id : "Not available" }}</div>
                                <label class="col-md-3 col-sm-3 col-xs-6">Source Name:</label>
                                <div class="col-md-3 col-sm-3 col-xs-6">{{ isset($user->userBookingDetail->source_name) ? $user->userBookingDetail->source_name : "Not available" }}</div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-sm-3 col-xs-6">Check In Date:</label>
                                <div class="col-md-3 col-sm-3 col-xs-6">{{ isset($user->userBookingDetail->check_in) ? $user->userBookingDetail->check_in : "Not available" }}</div>
                                <label class="col-md-3 col-sm-3 col-xs-6">Check In Time:</label>
                                <div class="col-md-3 col-sm-3 col-xs-6">{{ isset($user->userBookingDetail->check_in_time) ? $user->userBookingDetail->check_in_time : "Not available" }}</div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-sm-3 col-xs-6">Check Out Date:</label>
                                <div class="col-md-3 col-sm-3 col-xs-6">{{ isset($user->userBookingDetail->check_out) ? $user->userBookingDetail->check_out : "Not available" }}</div>
                                <label class="col-md-3 col-sm-3 col-xs-6">Check Out Time:</label>
                                <div class="col-md-3 col-sm-3 col-xs-6">{{ isset($user->userBookingDetail->check_out_time) ? $user->userBookingDetail->check_out_time : "Not available" }}</div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-sm-3 col-xs-6">Resort Name:</label>
                                <div class="col-md-3 col-sm-3 col-xs-6">{{ isset($user->userBookingDetail->resort) && $user->userBookingDetail->resort != null ? $user->userBookingDetail->resort->name : "Not available" }}</div>
                                <label class="col-md-3 col-sm-3 col-xs-6">Room No.:</label>
                                <div class="col-md-3 col-sm-3 col-xs-6">{{ isset($user->userBookingDetail->room_detail) && $user->userBookingDetail->room_detail != null ? $user->userBookingDetail->room_detail->room_no : "Not available" }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <h2>Booking Details ( {{ $user->user_name }} )</h2>
                <div class="pull-right">
                    <a class="btn btn-info" href="{{ route('admin.users.index') }}">Back</a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading"><label>Booking Details</label></div>
                        <div class="panel-body">
                            <div class="row">
                                <label class="col-md-3 col-sm-3 col-xs-6">Booking Id</label>
                                <div class="col-md-3 col-sm-3 col-xs-6">{{ isset($userBookingdetail->source_id) ? $userBookingdetail->source_id : "Not available" }}</div>
                                <label class="col-md-3 col-sm-3 col-xs-6">Source Name</label>
                                <div class="col-md-3 col-sm-3 col-xs-6">{{ isset($userBookingdetail->source_name) ? $userBookingdetail->source_name : "Not available" }}</div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-sm-3 col-xs-6">Check In Date</label>
                                <div class="col-md-3 col-sm-3 col-xs-6">{{ isset($userBookingdetail->check_in) ? date("d-M-Y", strtotime($userBookingdetail->check_in)) : "Not available" }}</div>
                                <label class="col-md-3 col-sm-3 col-xs-6">Check In Time</label>
                                <div class="col-md-3 col-sm-3 col-xs-6">{{ isset($userBookingdetail->check_in) ? date("h:i A", strtotime($userBookingdetail->check_in)) : "Not available" }}</div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-sm-3 col-xs-6">Check Out Date</label>
                                <div class="col-md-3 col-sm-3 col-xs-6">{{ isset($userBookingdetail->check_out) ? date("d-M-Y", strtotime($userBookingdetail->check_out)) : "Not available" }}</div>
                                <label class="col-md-3 col-sm-3 col-xs-6">Check Out Time</label>
                                <div class="col-md-3 col-sm-3 col-xs-6">{{ isset($userBookingdetail->check_out) ? date("h:i A", strtotime($userBookingdetail->check_out)) : "Not available" }}</div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-sm-3 col-xs-6">Resort Name</label>
                                <div class="col-md-3 col-sm-3 col-xs-6">{{ isset($userBookingdetail->resort) && $userBookingdetail->resort != null ? $userBookingdetail->resort->name : "Not available" }}</div>
                                <label class="col-md-3 col-sm-3 col-xs-6">Room No.</label>
                                <div class="col-md-3 col-sm-3 col-xs-6">{{ isset($userBookingdetail->resort_room_no) ? $userBookingdetail->resort_room_no : "Not available" }}</div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-sm-3 col-xs-6">Check In</label>
                                <div class="col-md-3 col-sm-3 col-xs-6">
                                    @if($userBookingdetail->is_verified_check_in_pin)
                                    <span class="label label-success">Verified</span>
                                    @else
                                    <span class="label label-danger">Not Verified</span>
                                    @endif
                                </div>
                                <label class="col-md-3 col-sm-3 col-xs-6">Check Out</label>
                                <div class="col-md-3 col-sm-3 col-xs-6">
                                    @if($userBookingdetail->is_verified_check_out_pin)
                                    <span class="label label-success">Verified</span>
                                    @else
                                    <span class="label label-danger">Not Verified</span>
                                    @endif
                                </div>
                            </div>
                            @if((!$userBookingdetail->is_verified_check_in_pin) || (!$userBookingdetail->is_verified_check_out_pin))
                            <div class="ln_solid"></div>
                            <div class="row">
                                <div class="col-md-3 col-md-offset-4">
                                    <form method="post" action="{{route('admin.users.early-checkout', $userBookingdetail->id)}}" id="earlyCheckoutForm">
                                        @csrf
                                        <div class="form-group">
                                            <label for="">
                                                Enter early checkout date
                                            </label>
                                            <input readonly="true" type="text" name="early_checkout" id="early_checkout" class="form-control" >

                                        </div>
                                        <div class="form-group">
                                            <label for=""></label>
                                            <button type="submit" class="btn btn-success">Submit</button>
                                        </div>
                                    </form>
                                </div>
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

@section('script')
<script>
    $(document).ready(function () {
        $('#early_checkout').daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            singleClasses: "picker_2",
            minDate: new Date(),
            maxDate: "{{ $userBookingdetail->check_out }}",
            locale: {
                format: 'YYYY/M/DD hh:mm:ss A'
            }
        });

        $("#earlyCheckoutForm").validate({
            ignore: [],
            rules: {
                early_checkout: {
                    required: true,
                },
            }
        });
    });
</script>
@endsection
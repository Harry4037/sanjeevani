@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <h2>Update Booking</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>

                <form class="form-horizontal form-label-left" action="{{ route('admin.users.booking-edit', $data->id) }}" method="post" id="addBookingForm">
                    @csrf
                    <!--                    <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Discount (%)</label>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <input type="number" class="form-control" placeholder="Discount" name="discount" id="discount" value="{{ $data->discount }}">
                                            </div>
                                        </div>-->
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Booking Source Name*</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" class="form-control" placeholder="Booking Source Name" name="booking_source_name" id="booking_source_name" value="{{ $data->source_name }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Booking Source ID*</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" class="form-control" placeholder="Booking Source ID" name="booking_source_id" id="booking_source_id" value="{{ $data->source_id }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Check In*</label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input readonly type="text" class="form-control has-feedback-left" id="check_in" name="check_in" value='@if(!$flag){{ date("Y/m/d h:s:i A", strtotime($data->check_in))}}@endif' >
                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Check Out*</label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input readonly type="text" class="form-control has-feedback-left" id="check_out" name="check_out" value='@if(!$flag){{ date("Y/m/d h:s:i A", strtotime($data->check_out))}}@endif'>
                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Resort*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="resort_id" name="resort_id">
                                <option value="">Select option</option>
                                @if($resorts)
                                @foreach($resorts as $resort)
                                <option value="{{ $resort->id }}"
                                        @if($data->resort_id == $resort->id)
                                        {{ "selected" }}
                                        @endif
                                        >{{ $resort->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Resort Room Type*</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="resort_room_type" id="resort_room_type">
                                <option value="">Choose option</option>
                                @if($roomTypes)
                                @foreach($roomTypes as $roomType)
                                <option value="{{ $roomType->id }}"
                                        @if($data->room_type_id == $roomType->id)
                                        {{ "selected" }}
                                        @endif
                                        >{{ $roomType->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Resort Room No.*</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="resort_room_id" id="resort_room_id">
                                @if($resortRoom)
                                <option value="{{ $resortRoom->id }}" selected>{{ $resortRoom->room_no }}</option>
                                @endif
                            </select>
                        </div>
                        <input type="hidden" name="resort_room_id_hidden" id="resort_room_id_hidden" value="{{ old('resort_room_id_hidden') }}">
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Package detail*</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="package_id" id="package_id">
                                <option value="">Choose option</option>
                                @if($healcarePackages)
                                @foreach($healcarePackages as $healcarePackage)
                                <option value="{{ $healcarePackage->id }}"
                                        @if($data->package_id == $healcarePackage->id){{ "selected" }}@endif
                                        >{{ $healcarePackage->name }}</option>
                                @endforeach
                                @endif

                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-2">People Accompanying</label>
                    </div>
                    <div class="ln_solid"></div>
                    <div id="member_div">
                        @if($BookingPeoples)
                        @foreach($BookingPeoples as $BookingPeople)
                        <input value="{{ $BookingPeople->id }}" type="hidden" name="record_id[]">
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Person Name</label>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <input value="{{ $BookingPeople->person_name }}" type="text" class="form-control" name="person_name[]">
                            </div>
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Person Age</label>

                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <input value="{{ $BookingPeople->person_age }}" type="text" class="form-control" name="person_age[]">
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="col-md-2 col-sm-2 col-xs-12 col-md-offset-10">
                            <button type="button" class="btn btn-primary" id="add_more_member">Add Members</button>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                            <a class="btn btn-default" href="{{ route('admin.users.booking', $data->user_id) }}">Cancel</a>
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function () {
    @if ($flag)
            $('#check_in').daterangepicker({
    singleDatePicker: true,
            timePicker: true,
            singleClasses: "picker_2",
            startDate: new Date("{{ $data->check_in }}"),
            minDate: new Date(),
            locale: {
            format: 'YYYY/MM/DD hh:mm:ss A'
            }
    }, function (start, end, label) {
    $('#check_out').daterangepicker({
    singleDatePicker: true,
            timePicker: true,
            singleClasses: "picker_2",
            startDate: start,
            locale: {
            format: 'YYYY/MM/DD hh:mm:ss A'
            }});
    });
    $('#check_out').daterangepicker({
    singleDatePicker: true,
            timePicker: true,
            singleClasses: "picker_2",
            startDate: new Date("{{ $data->check_out }}"),
            locale: {
            format: 'YYYY/MM/DD hh:mm:ss A'
            }});
    @endif

            $(document).on("click", "#add_more_member", function () {
    var member_html = "<input value='0' type='hidden' name='record_id[]'>"
            + "<div class='form-group'><label class='control-label col-md-2 col-sm-2 col-xs-12'>Person Name</label><div class='col-md-2 col-sm-2 col-xs-12'><input type='text' class='form-control' name='person_name[]'>"
            + "</div><label class='control-label col-md-2 col-sm-2 col-xs-12'>Person Age</label><div class='col-md-2 col-sm-2 col-xs-12'>"
            + "<input type='text' class='form-control' name='person_age[]'></div>"
//                    +"<label class='control-label col-md-2 col-sm-2 col-xs-12'>Person Type</label><div class='col-md-2 col-sm-2 col-xs-12'>"
//                    + "<select class='form-control' name='person_type[]'><option value='Adult'>Adult</option><option value='Child'>Children</option></select>"
            + "</div></div>";
    $("#member_div").append(member_html);
    });
    $(document).on("change", "#resort_room_type", function () {
    var resort = $("#resort_id :selected").val();
    var resort_room = $("#resort_room_type :selected").val();
    var check_in = $("#check_in").val();
    var check_out = $("#check_out").val();
    if (!resort) {
    alert("Please select resort.")
            return false;
    } else if (!resort_room) {
    alert("Please select resort room type.")
            return false;
    } else {
    $.ajax({
    url: _baseUrl + '/admin/resort/resort-rooms',
            type: 'post',
            data: {
            "resort": resort,
                    "resort_room": resort_room,
                    "check_in": check_in,
                    "check_out": check_out,
            },
            dataType: 'html',
            success: function (res) {
            $("#resort_room_id").html(res);
            }
    });
    }
    });
    $(document).on("change", "#resort_room_id", function () {
    var record_val = $("#resort_room_id :selected").text();
    ;
    $("#resort_room_id_hidden").val(record_val);
    });
    $("#addBookingForm").validate({
    ignore: [],
            rules: {
//                discount: {
//                    required: true,
//                    number: true,
//                    min: 0,
//                    max: 100,
//                },
            user: {
            required: true
            },
                    booking_source_name: {
                    required: true
                    },
                    booking_source_id: {
                    required: true
                    },
                    check_in: {
                    required: true
                    },
                    check_out: {
                    required: true
                    },
                    resort_id: {
                    required: true
                    },
                    resort_room_type: {
                    required: true
                    },
                    resort_room_id: {
                    required: true
                    },
                    package_id: {
                    required: true
                    },
            }
    });
    $(document).on("change", "#resort_id", function () {
    var resort_id = $("#resort_id :selected").val();
    if (!resort_id) {
    alert("Please select resort.")
            return false;
    } else {
    $.ajax({
    url: _baseUrl + '/admin/room-type/resort-room-type/' + resort_id,
            type: 'get',
            beforeSend: function () {
            $(".overlay").show();
            },
            success: function (res) {
            $(".overlay").hide();
            $("#resort_room_type").html(res);
            }
    });
    }
    });
    $(document).on("change", "#resort_room_id", function () {
    var resort = $("#resort_id :selected").val();
    if (!resort) {
    alert("Please select resort.")
            return false;
    } else {
    $.ajax({
    url: _baseUrl + '/admin/resort/resort-healthcare/' + resort,
            type: 'get',
            dataType: 'html',
            beforeSend: function () {
            $(".overlay").show();
            },
            success: function (res) {
            $("#package_id").html(res);
            $(".overlay").hide();
            }
    });
    }
    });
    });
</script>
@endsection
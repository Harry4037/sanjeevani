@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <h2>Create Booking</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>

                <form class="form-horizontal form-label-left" action="{{ route('admin.users.booking-create', $user_id) }}" method="post" id="addBookingForm">
                    @csrf
                    <!--                    <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Discount (%)</label>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <input type="number" class="form-control" placeholder="Discount" name="discount" id="discount" value="0">
                                            </div>
                                        </div>-->
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Booking Source Name*</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" class="form-control" placeholder="Booking Source Name" name="booking_source_name" id="booking_source_name" value="{{ old('booking_source_name') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Booking Source ID*</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" class="form-control" placeholder="Booking Source ID" name="booking_source_id" id="booking_source_id" value="{{ old('booking_source_id') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Check In*</label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input readonly type="text" class="form-control has-feedback-left" id="check_in" name="check_in" >
                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Check Out*</label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input readonly type="text" class="form-control has-feedback-left" id="check_out" name="check_out">
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
                                <option value="{{ $resort->id }}">{{ $resort->name }}</option>
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
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Resort Room No.*</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="resort_room_id" id="resort_room_id">
                                @if(old('resort_room_id'))
                                <option value="{{ old('resort_room_id') }}" selected>{{ old('resort_room_id_hidden') }}</option>
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
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-2">People Accompanying</label>
                    </div>
                    <div class="ln_solid"></div>
                    <div id="member_div">
                    </div>
                    <div class="form-group">
                        <div class="col-md-2 col-sm-2 col-xs-12 col-md-offset-10">
                            <button type="button" class="btn btn-primary" id="add_more_member">Add Members</button>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                            <a class="btn btn-default" href="{{ route('admin.users.booking', $user_id) }}">Cancel</a>
                            <button type="submit" class="btn btn-success">Submit</button>
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

        $('#check_in').daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            startDate: new Date(),
            minDate: new Date(),
            singleClasses: "picker_2",
            locale: {
                format: 'YYYY/M/DD hh:mm:ss A'
            }
        }, function (start, end, label) {
            $('#check_out').daterangepicker({
                singleDatePicker: true,
                timePicker: true,
                singleClasses: "picker_2",
                startDate: start,
                minDate: start,
                locale: {
                    format: 'YYYY/M/DD hh:mm:ss A'
                }});

        });

        $('#check_out').daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            singleClasses: "picker_2",
            startDate: moment().startOf('hour').add(24, 'hour'),
            locale: {
                format: 'YYYY/M/DD hh:mm:ss A'
            }});

        $(document).on("click", "#add_more_member", function () {
            var member_html = "<div class='form-group'><label class='control-label col-md-2 col-sm-2 col-xs-12'>Person Name</label><div class='col-md-2 col-sm-2 col-xs-12'><input type='text' class='form-control' name='person_name[]'>"
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
                    beforeSend: function () {
                        $(".overlay").show();
                    },
                    success: function (res) {
                        $("#resort_room_id").html(res);
                        $(".overlay").hide();
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
// 
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
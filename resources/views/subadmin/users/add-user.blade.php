@extends('layouts.subadmin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <h2>Check In User </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>

                <form class="form-horizontal form-label-left" action="{{ route('subadmin.users.add') }}" method="post" id="addUserForm" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">General Details</label>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input  type="text" class="form-control" placeholder="Customer Name" name="user_name" id="user_name" value="{{ old('user_name') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer Phone Number</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input  type="text" class="form-control" placeholder="Customer Phone Number" name="mobile_number" id="mobile_number" value="{{ old('mobile_number') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer Email Address</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" class="form-control" placeholder="Customer Email Address" name="email_id" id="email_id" value="{{ old('email_id') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">Health Details</label>
                    </div>
                    <div class="ln_solid"></div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Daibeties</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="is_diabeties" id="is_diabeties">
                                <option value="">Choose option</option>
                                <option value="1" @if(old('is_diabeties') == '1'){{ "selected" }}@endif>Yes</option>
                                <option value="0" @if(old('is_diabeties') == '0'){{ "selected" }}@endif>No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">PP</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="is_ppa" id="is_ppa">
                                <option value="">Choose option</option>
                                <option value="1" @if(old('is_ppa') == '1'){{ "selected" }}@endif>Yes</option>
                                <option value="0" @if(old('is_ppa') == '0'){{ "selected" }}@endif>No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">HBA1C</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="hba_1c" id="hba_1c">
                                <option value="">Choose option</option>
                                <option value="1" @if(old('hba_1c') == '1'){{ "selected" }}@endif>Yes</option>
                                <option value="0" @if(old('hba_1c') == '0'){{ "selected" }}@endif>No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Fasting</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" class="form-control" placeholder="Fasting" name="fasting" id="fasting" value="{{ old('fasting') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">BP</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" class="form-control" placeholder="BP" name="bp" id="bp" value="{{ old('bp') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Insulin Dependency</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" class="form-control" placeholder="Insulin Dependency" name="insullin_dependency" id="insullin_dependency" value="{{ old('insullin_dependency') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Medical Document</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="file" class="form-control" placeholder="Medical Document" name="medical_documents" id="medical_documents" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">Booking Details</label>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Booking Source Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" class="form-control" placeholder="Booking Source Name" name="booking_source_name" id="booking_source_name" value="{{ old('booking_source_name') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Booking Source ID</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" class="form-control" placeholder="Booking Source ID" name="booking_source_id" id="booking_source_id" value="{{ old('booking_source_id') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Check In</label>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <input readonly type="text" class="form-control has-feedback-left" id="check_in" name="check_in" >
                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Check Out</label>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <input readonly type="text" class="form-control has-feedback-left" id="check_out" name="check_out">
                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Resort Room Type</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="resort_room_type" id="resort_room_type">
                                <option value="">Choose option</option>
                                @if($roomTypes)
                                @foreach($roomTypes as $roomType)
                                <option value="{{ $roomType->id }}" @if(old('resort_room_type') == $roomType->id){{ "selected" }}@endif>{{ $roomType->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Resort Room No.</label>
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Package detail</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="package_id" id="package_id">
                                <option value="">Choose option</option>
                                @if($healcarePackages)
                                @foreach($healcarePackages as $healcarePackage)
                                <option value="{{ $healcarePackage->id }}"
                                        @if(isset($userBooking->package_id) && $userBooking->package_id == $healcarePackage->id)
                                        {{ "selected" }}
                                        @endif
                                        >{{ $healcarePackage->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">People Accompanying</label>
                    </div>
                    <div class="ln_solid"></div>
                    <div id="member_div">
                        @if(old('person_name'))

                        @foreach(old('person_name') as $key => $pp)
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Person Name</label>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <input type="text" class="form-control" name="person_name[]" value="{{ $pp }}">
                            </div>
                            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Person Age</label>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <input type="text" class="form-control" name="person_age[]" value="{{ old('person_age')[$key] }}">
                            </div>
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Person Type</label>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <select class="form-control" name="person_type[]" >
                                    <option value="Adult" @if(old('person_type')[$key] == 'Adult'){{ "selected" }} @endif>Adult</option>
                                    <option value="Children" @if(old('person_type')[$key] == 'Children'){{ "selected" }} @endif>Children</option>
                                </select>
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
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-5">
                            <a class="btn btn-default" href="{{ route('subadmin.users.index') }}">Cancel</a>
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
            singleClasses: "picker_2",
            minDate: new Date(),
            startDate: new Date(),
            locale: {
                format: 'YYYY/M/DD hh:mm:ss A'
            }
        }, function (start, end, label) {
        });

        $('#check_out').daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            singleClasses: "picker_2",
            startDate: moment().startOf('hour').add(24, 'hour'),
            minDate: moment().startOf('hour').add(24, 'hour'),
            locale: {
                format: 'YYYY/M/DD hh:mm:ss A'
            }});
        $(document).on("click", "#add_more_member", function () {
            var member_html = "<div class='form-group'><label class='control-label col-md-2 col-sm-2 col-xs-12'>Person Name</label><div class='col-md-2 col-sm-2 col-xs-12'><input type='text' class='form-control' name='person_name[]'>"
                    + "</div><label class='control-label col-md-2 col-sm-2 col-xs-12'>Person Age</label><div class='col-md-2 col-sm-2 col-xs-12'>"
                    + "<input type='text' class='form-control' name='person_age[]'></div><label class='control-label col-md-2 col-sm-2 col-xs-12'>Person Type</label><div class='col-md-2 col-sm-2 col-xs-12'>"
                    + "<select class='form-control' name='person_type[]'><option value='Adult'>Adult</option><option value='Child'>Children</option></select>"
                    + "</div></div>";
            $("#member_div").append(member_html);
        });

        $("#addUserForm").validate({
            rules: {
                booking_source_name: {
                    required: true
                },
                booking_source_id: {
                    required: true
                },
                user_name: {
                    required: true
                },
                mobile_number: {
                    required: true,
                    number: true,
                    minlength: 10,
                    maxlength: 10,
                },
                email_id: {
                    required: true,
                    email: true
                },
                check_in: {
                    required: true
                },
                check_out: {
                    required: true
                },
//                resort_id: {
//                    required: true
//                },
                resort_room_type: {
                    required: true
                },
                resort_room_id: {
                    required: true
                },
                package_id: {
                    required: true
                },
                is_diabeties: {
                    required: true
                },
                is_ppa: {
                    required: true
                },
                hba_1c: {
                    required: true
                },
                fasting: {
                    required: true
                },
                bp: {
                    required: true
                },
                insullin_dependency: {
                    required: true
                },
                medical_documents: {
                    required: true
                },
            }});

        $(document).on("change", "#resort_room_type", function () {
            try {
                var resort = {{ $resort }};
                var resort_room = $("#resort_room_type :selected").val();
                var check_in = $("#check_in").val();
                var check_out = $("#check_out").val();
                if (!resort_room) {
                    alert("Please select resort room type.")
                    return false;
                } else {
                    $.ajax({
                        url: _baseUrl + '/sub-admin/resort/resort-rooms',
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
            } catch (err) {
                alert(err.message);
                $(".overlay").hide();
            }
        });
        $(document).on("change", "#resort_room_id", function () {
            var record_val = $("#resort_room_id :selected").text();
            $("#resort_room_id_hidden").val(record_val);
        });
    });
</script>

@endsection
@extends('layouts.admin.app')

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

                <form class="form-horizontal form-label-left" action="{{ route('admin.users.add') }}" method="post" id="addUserForm" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">General Details</label>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer Name*</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input  type="text" class="form-control" placeholder="Customer Name" name="user_name" id="user_name" value="{{ old('user_name') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer Phone Number*</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input  type="text" class="form-control" placeholder="Customer Phone Number" name="mobile_number" id="mobile_number" value="{{ old('mobile_number') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer Email Address*</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" class="form-control" placeholder="Customer Email Address" name="email_id" id="email_id" value="{{ old('email_id') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Discount*</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="number" class="form-control" placeholder="Discount" name="discount" id="discount" value="0">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Health Details</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <p style="padding: 5px;">
                                <input class="flat" type="checkbox" id="is_medical_document" name="is_medical_document">
                            <p>
                        </div>
                    </div>
                    <div id="user_medical_detail_div" style="display: none;">
                        <div class="ln_solid"></div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Daibeties*</label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <select class="form-control" name="is_diabeties" id="is_diabeties">
                                    <option value="">Choose option</option>
                                    <option value="1" @if(old('is_diabeties') == '1'){{ "selected" }}@endif>Yes</option>
                                    <option value="0" @if(old('is_diabeties') == '0'){{ "selected" }}@endif>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">PP*</label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <select class="form-control" name="is_ppa" id="is_ppa">
                                    <option value="">Choose option</option>
                                    <option value="1" @if(old('is_ppa') == '1'){{ "selected" }}@endif>Yes</option>
                                    <option value="0" @if(old('is_ppa') == '0'){{ "selected" }}@endif>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">HBA1C*</label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <select class="form-control" name="hba_1c" id="hba_1c">
                                    <option value="">Choose option</option>
                                    <option value="1" @if(old('hba_1c') == '1'){{ "selected" }}@endif>Yes</option>
                                    <option value="0" @if(old('hba_1c') == '0'){{ "selected" }}@endif>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Fasting*</label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <input type="text" class="form-control" placeholder="Fasting" name="fasting" id="fasting" value="{{ old('fasting') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">BP*</label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <input type="text" class="form-control" placeholder="BP" name="bp" id="bp" value="{{ old('bp') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Insulin Dependency*</label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <input type="text" class="form-control" placeholder="Insulin Dependency" name="insullin_dependency" id="insullin_dependency" value="{{ old('insullin_dependency') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Medical Document*</label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <input type="file" class="form-control" placeholder="Medical Document" name="medical_documents" id="medical_documents" >
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Membership Details</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <p style="padding: 5px;">
                                <input class="flat" type="checkbox" id="is_membership_details" name="is_membership_details">
                            <p>
                        </div>
                    </div>
                    <div id="user_membership_div" style="display: none;">
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Membership Id*</label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <input type="text" class="form-control" placeholder="Membership Id" name="membership_id" id="membership_id" value="{{ old('membership_id') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Membership From*</label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <input readonly type="text" class="form-control" placeholder="Membership From" name="membership_from" id="membership_from" value="{{ old('membership_from') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Membership Till*</label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <input readonly type="text" class="form-control" placeholder="Membership Till" name="membership_till" id="membership_till" value="{{ old('membership_till') }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Booking Details</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <p style="padding: 5px;">
                                <input class="flat" type="checkbox" id="is_booking_details" name="is_booking_details">
                            <p>
                        </div>
                    </div>
                    <div id="user_booking_div" style="display: none;">
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Booking Details</label>
                        </div>
                        <div class="ln_solid"></div>
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
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <input readonly type="text" class="form-control has-feedback-left" id="check_in" name="check_in" >
                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Check Out*</label>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <input readonly type="text" class="form-control has-feedback-left" id="check_out" name="check_out">
                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Resort Name*</label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <select class="form-control" name="resort_id" id="resort_id">
                                    <option value="">Choose option</option>
                                    @if($resorts)
                                    @foreach($resorts as $resort)
                                    <option value="{{ $resort->id }}" @if(old('resort_id') == $resort->id){{ "selected" }}@endif>{{ $resort->name }}</option>
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
<!--                                    @if($roomTypes)
                                    @foreach($roomTypes as $roomType)
                                    <option value="{{ $roomType->id }}" @if(old('resort_room_type') == $roomType->id){{ "selected" }}@endif>{{ $roomType->name }}</option>
                                    @endforeach
                                    @endif-->
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
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-5">
                            <a class="btn btn-default" href="{{ route('admin.users.index') }}">Cancel</a>
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
            locale: {
                format: 'YYYY/M/DD hh:mm:ss A'
            }
        }, function (start, end, label) {
            $('#check_out').daterangepicker({
                singleDatePicker: true,
                timePicker: true,
                singleClasses: "picker_2",
                minDate: start,
                locale: {
                    format: 'YYYY/M/DD hh:mm:ss A'
                }});
        });

        $('#check_out').daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            singleClasses: "picker_2",
            minDate: moment().startOf('hour').add(24, 'hour'),
            locale: {
                format: 'YYYY/M/DD hh:mm:ss A'
            }});

        $('#membership_from').daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            singleClasses: "picker_2",
            minDate: new Date(),
            locale: {
                format: 'YYYY/M/DD hh:mm:ss A'
            }
        }, function (start, end, label) {
            $('#membership_till').daterangepicker({
                singleDatePicker: true,
                timePicker: true,
                singleClasses: "picker_2",
                minDate: start,
                locale: {
                    format: 'YYYY/M/DD hh:mm:ss A'
                }});
        });

        $('#membership_till').daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            singleClasses: "picker_2",
            minDate: moment().startOf('hour').add(24, 'hour'),
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

        $("#addUserForm").validate({
            rules: {
//                booking_source_name: {
//                    required: true
//                },
//                booking_source_id: {
//                    required: true
//                },
                user_name: {
                    required: true
                },
                mobile_number: {
                    required: true,
                    number: true,
                    maxlength: 10,
                    minlength: 10,
                },
                email_id: {
                    required: true,
                    email: true
                },
                discount: {
                    required: true,
                    number: true,
                    min: 0,
                    max: 100,
                },
//                check_in: {
//                    required: true
//                },
//                check_out: {
//                    required: true
//                },
//                resort_id: {
//                    required: true
//                },
//                resort_room_type: {
//                    required: true
//                },
//                resort_room_id: {
//                    required: true
//                },
//                package_id: {
//                    required: true
//                },
//                is_diabeties: {
//                    required: true
//                },
//                is_ppa: {
//                    required: true
//                },
//                hba_1c: {
//                    required: true
//                },
//                fasting: {
//                    required: true
//                },
//                bp: {
//                    required: true
//                },
//                insullin_dependency: {
//                    required: true
//                },
//                medical_documents: {
//                    required: true
//                },
            }});


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

        $(document).on("change", "#resort_room_id", function () {
            var record_val = $("#resort_room_id :selected").text();
            $("#resort_room_id_hidden").val(record_val);
        });

        if ($("input.flat")[0]) {
            $(document).ready(function () {
                $('input.flat').iCheck({
                    checkboxClass: 'icheckbox_flat-green',
                    radioClass: 'iradio_flat-green'
                });
            });
        }

        $('#is_medical_document').on('ifChecked', function () {
            $("#is_diabeties").rules("add", {required: true});
            $("#is_ppa").rules("add", {required: true});
            $("#hba_1c").rules("add", {required: true});
            $("input[name='fasting']").rules("add", {required: true});
            $("input[name='bp']").rules("add", {required: true});
            $("input[name='insullin_dependency']").rules("add", {required: true});
            $("#user_medical_detail_div").css("display", "block");
        });
        $('#is_medical_document').on('ifUnchecked', function () {
            $("#is_diabeties").rules("remove", "required");
            $("#is_ppa").rules("remove", "required");
            $("#hba_1c").rules("remove", "required");
            $("input[name='fasting']").rules("remove", "required");
            $("input[name='bp']").rules("remove", "required");
            $("input[name='insullin_dependency']").rules("remove", "required");
            $("#user_medical_detail_div").css("display", "none");
        });

        $('#is_membership_details').on('ifChecked', function () {
            $("#membership_id").rules("add", {required: true});
            $("#membership_from").rules("add", {required: true});
            $("#membership_till").rules("add", {required: true});
            $("#user_membership_div").css("display", "block");
        });
        $('#is_membership_details').on('ifUnchecked', function () {
            $("#membership_id").rules("remove", "required");
            $("#membership_from").rules("remove", "required");
            $("#membership_till").rules("remove", "required");
            $("#user_membership_div").css("display", "none");
        });

        $('#is_booking_details').on('ifChecked', function () {
            $("#booking_source_name").rules("add", {required: true});
            $("#booking_source_id").rules("add", {required: true});
            $("#check_in").rules("add", {required: true});
            $("#check_out").rules("add", {required: true});
            $("#resort_id").rules("add", {required: true});
            $("#resort_room_type").rules("add", {required: true});
            $("#resort_room_id").rules("add", {required: true});
            $("#package_id").rules("add", {required: true});
            $("#user_booking_div").css("display", "block");
        });
        $('#is_booking_details').on('ifUnchecked', function () {
            $("#booking_source_name").rules("add", "required");
            $("#booking_source_id").rules("add", "required");
            $("#check_in").rules("add", "required");
            $("#check_out").rules("add", "required");
            $("#resort_id").rules("add", "required");
            $("#resort_room_type").rules("add", "required");
            $("#resort_room_id").rules("add", "required");
            $("#package_id").rules("add", "required");
            $("#user_booking_div").css("display", "none");
        });

    });
</script>

@endsection
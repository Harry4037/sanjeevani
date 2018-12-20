@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <h2>Udate User Details</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>

                <form class="form-horizontal form-label-left" action="{{ route('admin.users.edit', $user->id) }}" method="post" id="editUserForm" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">General Details</label>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            @if(isset($user->user_name))
                            <input value="{{ $user->user_name }}" type="text" class="form-control" placeholder="Customer Name" name="user_name" id="user_name">
                            @else
                            <input type="text" class="form-control" placeholder="Customer Name" name="user_name" id="user_name">
                            @endif

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer Phone Number</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            @if(isset($user->mobile_number))
                            <input value="{{ $user->mobile_number }}" type="text" class="form-control" placeholder="Customer Phone Number" name="mobile_number" id="mobile_number">
                            @else
                            <input type="text" class="form-control" placeholder="Customer Phone Number" name="mobile_number" id="mobile_number">
                            @endif

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer Email Address</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            @if(isset($user->email_id))
                            <input value="{{ $user->email_id }}" type="text" class="form-control" placeholder="Customer Email Address" name="email_id" id="email_id">
                            @else
                            <input type="text" class="form-control" placeholder="Customer Email Address" name="email_id" id="email_id">
                            @endif

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
                                @if(isset($userHealth->is_diabeties))
                                <option value="1" @if($userHealth->is_diabeties == '1'){{ "selected" }}@endif>Yes</option>
                                <option value="0" @if($userHealth->is_diabeties == '0'){{ "selected" }}@endif>No</option>
                                @else
                                <option value="1" >Yes</option>
                                <option value="0" >No</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">PP</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="is_ppa" id="is_ppa">
                                <option value="">Choose option</option>
                                @if(isset($userHealth->is_ppa))
                                <option value="1" @if($userHealth->is_ppa == '1'){{ "selected" }}@endif>Yes</option>
                                <option value="0" @if($userHealth->is_ppa == '0'){{ "selected" }}@endif>No</option>
                                @else
                                <option value="1" >Yes</option>
                                <option value="0" >No</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">HBA1C</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="hba_1c" id="hba_1c">
                                <option value="">Choose option</option>
                                @if(isset($userHealth->hba_1c))
                                <option value="1" @if($userHealth->hba_1c == '1'){{ "selected" }}@endif>Yes</option>
                                <option value="0" @if($userHealth->hba_1c == '0'){{ "selected" }}@endif>No</option>
                                @else
                                <option value="1" >Yes</option>
                                <option value="0" >No</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Fasting</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            @if(isset($userHealth->fasting))
                            <input type="text" class="form-control" placeholder="Fasting" name="fasting" id="fasting" value="{{ $userHealth->fasting }}">
                            @else
                            <input type="text" class="form-control" placeholder="Fasting" name="fasting" id="fasting" >
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">BP</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            @if(isset($userHealth->bp))
                            <input type="text" class="form-control" placeholder="BP" name="bp" id="bp" value="{{ $userHealth->bp }}">
                            @else
                            <input type="text" class="form-control" placeholder="BP" name="bp" id="bp" >
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Insulin Dependency</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            @if(isset($userHealth->insullin_dependency))
                            <input type="text" class="form-control" placeholder="Insulin Dependency" name="insullin_dependency" id="insullin_dependency" value="{{ $userHealth->insullin_dependency }}">
                            @else
                            <input type="text" class="form-control" placeholder="Insulin Dependency" name="insullin_dependency" id="insullin_dependency" >
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Medical Document</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="file" class="form-control" name="medical_documents" id="medical_documents" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">Booking Details</label>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Booking Source Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            @if(isset($userBooking->source_name))
                            <input value="{{ $userBooking->source_name }}" type="text" class="form-control" placeholder="Booking Source Name" name="booking_source_name" id="booking_source_name">
                            @else
                            <input type="text" class="form-control" placeholder="Booking Source Name" name="booking_source_name" id="booking_source_name">
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Booking Source ID</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            @if(isset($userBooking->source_id))
                            <input value="{{ $userBooking->source_id }}" type="text" class="form-control" placeholder="Booking Source ID" name="booking_source_id" id="booking_source_id">
                            @else
                            <input type="text" class="form-control" placeholder="Booking Source ID" name="booking_source_id" id="booking_source_id">
                            @endif

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Check In</label>
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <input readonly type="text" class="form-control has-feedback-left" id="check_in" name="check_in" >

                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Check Out</label>
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <input readonly type="text" class="form-control has-feedback-left" id="check_out" name="check_out">

                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Resort Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="resort_id" id="resort_id">
                                <option value="">Choose option</option>
                                @if($resorts)
                                @foreach($resorts as $resort)
                                <option value="{{ $resort->id }}" 
                                        @if(isset($userBooking->resort_id) && ($userBooking->resort_id == $resort->id))
                                        {{ "selected" }}
                                        @endif

                                        >{{ $resort->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Resort Room Type</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="resort_room_type" id="resort_room_type">
                                <option value="">Choose option</option>
                                @if($roomTypes)
                                @foreach($roomTypes as $roomType)
                                <option value="{{ $roomType->id }}"
                                        @if(isset($roomBooking->room_type_id))
                                        @if($roomType->id == $roomBooking->room_type_id)
                                        {{ "selected" }}
                                        @endif
                                        @endif

                                        >{{ $roomType->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Resort Room No.</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="resort_room_id" id="resort_room_id">
                                @if($resortRooms)
                                @foreach($resortRooms as $resortRoom)
                                <option value="{{ $resortRoom->id }}"
                                        @if(isset($roomBooking->room_room_id))
                                        @if($resortRoom->id == $roomBooking->room_room_id)
                                        {{ "selected" }}
                                        @endif
                                        @endif
                                        >{{ $resortRoom->room_no }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
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
                        <label class="control-label col-md-2 col-sm-2 col-xs-2">People Accompanying</label>
                    </div>
                    <div class="ln_solid"></div>
                    <div id="member_div">
                        @if(isset($bookingAccompany) && !empty($bookingAccompany))
                        @foreach($bookingAccompany as $bookingA)
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Person Name</label>
                            <div class="col-md-2 col-sm-2 col-xs-2">
                                <input value="{{ $bookingA->person_name }}" type="text" class="form-control" name="person_name[]">
                            </div>
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Person Age</label>
                            <div class="col-md-2 col-sm-2 col-xs-2">
                                <input value="{{ $bookingA->person_age }}" type="text" class="form-control" name="person_age[]">
                            </div>
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Person Type</label>
                            <div class="col-md-2 col-sm-2 col-xs-2">
                                <select class="form-control" name="person_type[]" >
                                    <option value="Adult" @if($bookingA->person_type == 'Adult'){{ "selected" }} @endif>Adult</option>
                                    <option value="Children" @if($bookingA->person_type == 'Children'){{ "selected" }} @endif>Children</option>
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
                            <a class="btn btn-default" href="{{ route('admin.users.index') }}">Cancel</a>
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
        var check_in = "@if(isset($roomBooking->check_in)){{ $roomBooking->check_in }} @endif";
        var check_out = "@if(isset($roomBooking->check_out)){{ $roomBooking->check_out }} @endif";
        $('#check_in').daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            singleClasses: "picker_2",
            startDate: new Date(check_in),
            locale: {
                format: 'YYYY/M/DD hh:mm:ss A'
            }
        });

        $('#check_out').daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            singleClasses: "picker_2",
            startDate: new Date(check_out),
            locale: {
                format: 'YYYY/M/DD hh:mm:ss A'
            }
        });

        $(document).on("click", "#add_more_member", function () {
            var member_html = "<div class='form-group'><label class='control-label col-md-2 col-sm-2 col-xs-12'>Person Name</label><div class='col-md-2 col-sm-2 col-xs-12'><input type='text' class='form-control' name='person_name[]'>"
                    + "</div><label class='control-label col-md-2 col-sm-2 col-xs-12'>Person Age</label><div class='col-md-2 col-sm-2 col-xs-12'>"
                    + "<input type='text' class='form-control' name='person_age[]'></div><label class='control-label col-md-2 col-sm-2 col-xs-12'>Person Type</label><div class='col-md-2 col-sm-2 col-xs-12'>"
                    + "<select class='form-control' name='person_type[]'><option value='Adult'>Adult</option><option value='Child'>Children</option></select>"
                    + "</div></div>";
            $("#member_div").append(member_html);
        });

        $("#editUserForm").validate({
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
                    required: true
                },
                email_id: {
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
//                medical_documents: {
//                    required: true
//                },
            }
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on("change", "#resort_room_type", function () {
            var resort = $("#resort_id :selected").val();
            var resort_room = $("#resort_room_type :selected").val();
            if (!resort) {
                alert("Please select resort.")
                return false;
            } else if (!resort_room) {
                alert("Please select resort room type.")
                return false;
            } else {
                $.ajax({
                    url: _baseUrl + '/admin/resort/resort-rooms/' + resort + '/' + resort_room,
                    type: 'get',
                    dataType: 'html',
                    success: function (res) {
                        $("#resort_room_id").html(res);
                    }
                });
            }

        });
    });
</script>

@endsection
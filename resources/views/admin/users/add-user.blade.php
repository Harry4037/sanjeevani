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

                <form class="form-horizontal form-label-left" action="{{ route('admin.users.add') }}" method="post" id="addUserForm">
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Booking Source Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" class="form-control" placeholder="Booking Source Name" name="booking_source_name" id="booking_source_name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Booking Source ID</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" class="form-control" placeholder="Booking Source ID" name="booking_source_id" id="booking_source_id">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" class="form-control" placeholder="Customer Name" name="user_name" id="user_name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer Phone Number</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" class="form-control" placeholder="Customer Phone Number" name="mobile_number" id="mobile_number">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer Email Address</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" class="form-control" placeholder="Customer Email Address" name="email_id" id="email_id">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Check In Date</label>
                        <div class="col-md-2 col-sm-2 col-xs-2">
                            <input type="text" class="form-control has-feedback-left" id="check_in" name="check_in" >
                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                        </div>
                        <label class="control-label col-md-2 col-sm-2 col-xs-2">Check Out Date</label>
                        <div class="col-md-2 col-sm-2 col-xs-2">
                            <input type="text" class="form-control has-feedback-left" id="check_out" name="check_out">
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
                                <option value="{{ $resort->id }}">{{ $resort->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Resort Room No.</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" class="form-control" placeholder="Resort Room No." name="resort_room_id" id="resort_room_id">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Package detail</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="package_id" id="package_id">
                                <option value="">Choose option</option>
                                <option value="1">Health Package 1</option>
                                <option value="2">Health 2</option>
                                <option value="3">Health 3</option>
                                <option value="4">Health 4</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-2">People Accompanying</label>
                    </div>
                    <div class="ln_solid"></div>
                    <div id="member_div">
<!--                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Person Name</label>
                            <div class="col-md-2 col-sm-2 col-xs-2">
                                <input type="text" class="form-control" name="person_name[]">
                            </div>
                            <label class="control-label col-md-2 col-sm-2 col-xs-2">Person Age</label>
                            <div class="col-md-2 col-sm-2 col-xs-2">
                                <input type="text" class="form-control" name="person_age[]">
                            </div>
                        </div>-->
                    </div>

                    <div class="form-group">
                        <div class="col-md-2 col-sm-2 col-xs-12 col-md-offset-8">
                            <button type="button" class="btn btn-primary" id="add_more_member">Add</button>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                            <!--                            <button type="button" class="btn btn-primary">Cancel</button>-->
                            <button type="reset" class="btn btn-primary">Reset</button>
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
            singleClasses: "picker_1",
        }, function (start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
        });

        $('#check_out').daterangepicker({
            singleDatePicker: true,
            singleClasses: "picker_1"
        }, function (start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
        });

        $(document).on("click", "#add_more_member", function () {
            var member_html = "<div class='form-group'><label class='control-label col-md-3 col-sm-3 col-xs-12'>Person Name</label><div class='col-md-2 col-sm-2 col-xs-2'><input type='text' class='form-control' name='person_name[]'>"
                    + "</div><label class='control-label col-md-2 col-sm-2 col-xs-2'>Person Age</label><div class='col-md-2 col-sm-2 col-xs-2'>"
                    + "<input type='text' class='form-control' name='person_age[]'>"
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
                resort_room_id: {
                    required: true
                },
                package_id: {
                    required: true
                }
            }
        });
    });
</script>

@endsection
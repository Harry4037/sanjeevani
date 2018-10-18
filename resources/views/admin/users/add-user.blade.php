@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Check In User </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <form class="form-horizontal form-label-left">

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
                            <input type="text" class="form-control" placeholder="Customer Phone Number" name="mobile_number" id="mobile_number">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Check In Date</label>
                        <div class="col-md-2 col-sm-2 col-xs-2">
                            <input type="text" class="form-control has-feedback-left" id="check_in" >
                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                        </div>
                        <label class="control-label col-md-2 col-sm-2 col-xs-2">Check Out Date</label>
                        <div class="col-md-2 col-sm-2 col-xs-2">
                            <input type="text" class="form-control has-feedback-left" id="check_out" >
                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Resort Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="resort_id" id="resort_id">
                                <option value="">Choose option</option>
                                <option value="1">ABC</option>
                                <option value="2">XYZ</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Resort Type</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="resort_type_id" id="resort_type_id">
                                <option value="">Choose option</option>
                                <option value="1">Type 1</option>
                                <option value="2">Type 2</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">No. of room</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="total_room" id="total_room">
                                <option value="">Choose option</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Package detail</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="package_detail" id="package_detail">
                                <option value="">Choose option</option>
                                <option value="1">Package 1</option>
                                <option value="2">Package 2</option>
                                <option value="3">Package 3</option>
                                <option value="4">Package 4</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-2">People Accompanying</label>
                    </div>
                    <div class="ln_solid"></div>
                    <div id="member_div">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Person Name</label>
                            <div class="col-md-2 col-sm-2 col-xs-2">
                                <input type="text" class="form-control" name="person_name[]">
                            </div>
                            <label class="control-label col-md-2 col-sm-2 col-xs-2">Person Age</label>
                            <div class="col-md-2 col-sm-2 col-xs-2">
                                <input type="text" class="form-control" name="person_age[]">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-2 col-sm-2 col-xs-12 col-md-offset-8">
                            <button type="button" class="btn btn-primary" id="add_more_member">Add more</button>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                            <button type="button" class="btn btn-primary">Cancel</button>
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

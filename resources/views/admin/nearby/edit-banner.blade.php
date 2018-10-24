@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <h2>Edit Resort</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <form class="form-horizontal form-label-left" action="" method="post" id="editResortForm" >
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Resort Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" class="form-control" name="edit_resort_name" id="edit_resort_name" placeholder="Resort Name" value="{{ $data->name }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Contact Number</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" class="form-control" name="edit_contact_no" id="edit_contact_no" placeholder="Contact Number" value="{{ $data->contact_number }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Room Type</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <p style="padding: 5px;">
                                @if($roomTypes)
                                @foreach($roomTypes as $roomType)
                                <input class="flat" type="checkbox" name="edit_room_types[]" value="{{ $roomType->id }}"  
                                       @if(in_array($roomType->id, $roomArray))
                                       {{ "checked" }}
                                       @endif
                                       > 
                                {{ $roomType->name }}
                                @endforeach
                                @endif
                            <p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Resort Description</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <textarea class="form-control" name="edit_resort_description" id="edit_resort_description" placeholder="Resort Description">{{ $data->description }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" class="form-control" name="edit_address" id="edit_address" placeholder="Address" value="{{ $data->address_1 }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Pincode</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" class="form-control" name="edit_pin_code" id="edit_pin_code" placeholder="Pincode" value="{{ $data->pincode }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">State</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="edit_state" id="edit_state">
                                <option value="">Choose option</option>
                                <option value="1" selected>UP</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">District</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="edit_district" id="edit_district">
                                <option value="">Choose option</option>
                                <option value="1" selected>Noida</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">City</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="edit_city" id="edit_city">
                                <option value="">Choose option</option>
                                <option value="1" selected>Sector 66</option>
                                <option value="2">Sector 22</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div id="map"></div>
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

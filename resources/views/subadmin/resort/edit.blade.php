@extends('layouts.subadmin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <h2>Update Resort Details</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <div class="form-horizontal form-label-left">
                    @if($resortImages)
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12"></label>
                        @foreach($resortImages as $resortImage)
                        <div class="col-md-2 col-sm-2 col-xs-6">
                            <img src="{{ $resortImage->image_name }}" class="img-pre">
                            <button style="margin-left: 40px;" class="btn btn-info btn-xs delete_resort_image" id="{{ $resortImage->id }}" >Remove</button>
                        </div>
                        @endforeach
                    </div>
                    @endif
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">Resort Images</label>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <form id="my-dropzone" class="dropzone" action="{{ route('subadmin.resort.upload-image') }}">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
                <div class="ln_solid"></div>
                <form class="form-horizontal form-label-left" action="{{ route('subadmin.resort.edit', $data->id) }}" method="post" id="editResortForm" enctype="multipart/form-data">
                    @csrf
                    <div id="resort_images_div"></div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Resort Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input readonly type="text" class="form-control" name="edit_resort_name" id="edit_resort_name" placeholder="Resort Name" value="{{ $data->name }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Contact Number</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="edit_contact_no" id="edit_contact_no" placeholder="Contact Number" value="{{ $data->contact_number }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Resort Description</label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <textarea class="form-control" name="edit_resort_description" id="edit_resort_description" placeholder="Resort Description">{{ $data->description }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="edit_address" id="edit_address" placeholder="Address" value="{{ $data->address_1 }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">State</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" name="state" id="state">
                                <option value="">Choose option</option>
                                @if($states)
                                @foreach($states as $state)
                                <option value="{{ $state->id }}"
                                        @if($selectedCity->state_id == $state->id)
                                        {{ "selected" }}
                                        @endif
                                        >{{ $state->state }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">City</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" name="city" id="city">
                                <option value="">Choose option</option>
                                @if($cities)
                                @foreach($cities as $city)
                                <option value="{{ $city->id }}"
                                        @if($selectedCity->id == $city->id)
                                        {{ "selected" }}
                                        @endif
                                        >{{ $city->city }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Pincode</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="edit_pin_code" id="edit_pin_code" placeholder="Pincode" value="{{ $data->pincode }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Latitude</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ $data->latitude }}" type="text" class="form-control" name="latitude" id="latitude" placeholder="Latitude">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Longitude</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ $data->longitude }}" type="text" class="form-control" name="longitude" id="longitude" placeholder="Longitude">
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Amenities</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <p style="padding: 5px;">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input class="flat" type="checkbox" name="aminities[]" value="1" @if(in_array(1, explode("#", $data->amenities))) {{ "checked" }} @endif>Wifi
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input class="flat" type="checkbox" name="aminities[]" value="2" @if(in_array(2, explode("#", $data->amenities))) {{ "checked" }} @endif>Swimming Pool
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input class="flat" type="checkbox" name="aminities[]" value="3" @if(in_array(3, explode("#", $data->amenities))) {{ "checked" }} @endif>Air Conditioner
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input class="flat" type="checkbox" name="aminities[]" value="4" @if(in_array(4, explode("#", $data->amenities))) {{ "checked" }} @endif>Room Service
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input class="flat" type="checkbox" name="aminities[]" value="5" @if(in_array(5, explode("#", $data->amenities))) {{ "checked" }} @endif>Restaurant
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input class="flat" type="checkbox" name="aminities[]" value="6" @if(in_array(6, explode("#", $data->amenities))) {{ "checked" }} @endif>Bar
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input class="flat" type="checkbox" name="aminities[]" value="7" @if(in_array(7, explode("#", $data->amenities))) {{ "checked" }} @endif>Gym/Fitness Center
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input class="flat" type="checkbox" name="aminities[]" value="8" @if(in_array(8, explode("#", $data->amenities))) {{ "checked" }} @endif>Parking
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input class="flat" type="checkbox" name="aminities[]" value="9" @if(in_array(9, explode("#", $data->amenities))) {{ "checked" }} @endif>Spa
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input class="flat" type="checkbox" name="aminities[]" value="10" @if(in_array(10, explode("#", $data->amenities))) {{ "checked" }} @endif>Pets
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input class="flat" type="checkbox" name="aminities[]" value="11" @if(in_array(11, explode("#", $data->amenities))) {{ "checked" }} @endif>Geyser
                                </div>
                            </div>
                            <p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Other Amenities</label>
                    </div>
                    <div id="other_amenity_div">
                        @if($data->other_amenities)
                        @foreach(explode("#", $data->other_amenities) as $am)
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-6 col-xs-12"></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control" name="other_amenities[]" value="{{ $am }}">
                            </div>
                            <i style='cursor:pointer' class='fa fa-times delete_this_div'></i>
                        </div>
                        @endforeach
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="col-md-2 col-sm-2 col-xs-12 col-md-offset-8 col-sm-offset-8 col-xs-offset-8">
                            <button type="button" class="btn btn-primary" id="add_more_amenity">Add Amenity</button>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Room Details</label>
                    </div>

                    <div id="room_detail_div">

                        @if($dataRooms)
                        @foreach($dataRooms as $k => $dataRoom)
                        <div class='form-group'>
                            <label class='control-label col-md-2 col-sm-2 col-xs-12'>Room No.</label>
                            <div class='col-md-2 col-sm-2 col-xs-12'>
                                <input value="{{ $dataRoom->room_no }}" type='text' class='form-control' name='room_no[{{$k}}]'>
                                <input value="{{ $dataRoom->id }}" type='hidden' name='room_id[{{$k}}]'>
                            </div>
                            <label class='control-label col-md-3 col-sm-3 col-xs-12'>Room Type</label>                         
                            <div class = 'col-md-2 col-sm-2 col-xs-11'>
                                <select class='form-control' name='room_type[{{$k}}]' id='room_type'>
                                    @if($roomTypes)
                                    @foreach($roomTypes as $roomType)
                                    <option value="{{ $roomType->id }}"
                                            @if($roomType->id == $dataRoom->room_type_id)
                                            {{ "selected" }}
                                            @endif
                                            >{{ $roomType->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <i style='cursor:pointer' class="fa fa-times delete_room" id="{{ $dataRoom->id }}"></i>
                        </div>
                        @endforeach
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="col-md-2 col-sm-2 col-xs-12 col-md-offset-8">
                            <button type="button" class="btn btn-primary" id="add_more_room">Add Room</button>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 text-center">
                            <a class="btn btn-default" href="{{ route('subadmin.dashboard') }}">Cancel</a>
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
<script src="{{ asset("/vendor/unisharp/laravel-ckeditor/ckeditor.js") }}"></script>
<script>
$(document).ready(function () {

var index = {{ count($dataRooms) }};

    if ($("input.flat")[0]) {
        $(document).ready(function () {
            $('input.flat').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            });
        });
    }

    $(document).on("click", "#add_more_amenity", function () {

        var amenity_html = "<div class='form-group'>"
                + "<label class='control-label col-md-3 col-sm-6 col-xs-12'></label>"
                + "<div class='col-md-6 col-sm-6 col-xs-12'>"
                + "<input type='text' class='form-control' name='other_amenities[]'>"
                + "</div>"
                + "<i style='cursor:pointer' class='fa fa-times delete_this_div'></i>"
                + "</div>";
        $("#other_amenity_div").append(amenity_html);
    });

//For ckeditor
    CKEDITOR.replace('edit_resort_description', {
        removeButtons: 'Cut,Copy,Paste,Undo,Redo,Anchor',
        removePlugins: 'image, link',
//        removePlugins: 'elementspath,save,image,flash,i frame,link,smiley,tabletools,find,pagebreak,templates,about,maximize,showblocks,newpage,language',
    });
    CKEDITOR.instances.edit_resort_description.on('change', function () {
        if (CKEDITOR.instances.edit_resort_description.getData().length > 0) {
            $('label[for="edit_resort_description"]').hide();
        }
    });

    jQuery.validator.addMethod("float_number", function (value, element) {
        return this.optional(element) || /^[-+]?[0-9]+\.[0-9]+$/.test(value);
    }, "Please provide valid lat & long value.");
    
    $("#editResortForm").validate({
        rules: {
            edit_resort_name: {
                required: true
            },
            edit_contact_no: {
                required: true,
                number: true,
                minlength: 10,
                maxlength: 10,
            },
            edit_resort_description: {
                required: true
            },
            edit_address: {
                required: true
            },
            edit_pin_code: {
                required: true,
                number: true,
                minlength: 6,
                maxlength: 6,
            },
            state: {
                required: true
            },
            latitude: {
                required: true,
                number: true,
                float_number: true,
            },
            longitude: {
                required: true,
                number: true,
                float_number: true,
            },
            city: {
                required: true
            }
        }
    });

    var roomTypes = <?php echo json_encode($roomTypes) ?>;

    var room_type = "";
    $.each(roomTypes, function (key, val) {
        room_type += "<option value='" + val.id + "'>" + val.name + "</option>";
    });
    $(document).on("click", "#add_more_room", function () {

        var member_html = "<div class='form-group'><label class='control-label col-md-2 col-sm-2 col-xs-2'>Room No.</label><div class='col-md-2 col-sm-2 col-xs-2'>"
                + "<input type='text' class='form-control' name='room_no["+index+"]'>"
                + "<input value=0 type='hidden' class='form-control' name='room_id["+index+"]'>"
                + "</div>"
        +"<label class='control-label col-md-3 col-sm-3 col-xs-12'>Room Type</label><div class = 'col-md-2 col-sm-2 col-xs-2'><select class='form-control' name='room_type["+index+"]' id='room_type'>"
        + room_type + 
        "</select></div>"
        +"<i style='cursor:pointer' class='fa fa-times delete_this_div'></i></div>";
        $("#room_detail_div").append(member_html);
        
        $("input[name='room_no[" + index + "]']").rules("add", {
            remote:  _baseUrl+ '/sub-admin/resort/check-room?resort={{$data->id}}',
            messages: {
                remote: "Room no. already exist.",
            }
        });
        index++;
    });

    $(document).on("click", ".delete_this_div", function () {
        $(this).parent("div").remove();
    });

    $(document).on('click', '.delete_room', function () {
        var record_id = this.id;
        var _this = $(this);
        if (record_id) {
            $.ajax({
                url: _baseUrl + '/sub-admin/resort/delete-room',
                type: 'post',
                data: {record_id: record_id},
                dataType: 'json',
                beforeSend: function () {
                    $(".overlay").show();
                },
                success: function (res) {
                    if (res.status)
                    {
                        $(".overlay").hide();
                        _this.parent("div").remove();
                        showSuccessMessage(res.message);
                    } else {
                        $(".overlay").hide();
                        showErrorMessage(res.message);
                    }
                }
            });

        }
    });

    $(document).on('click', '.delete_resort_image', function () {
        var record_id = this.id;
        var _this = $(this);
        if (record_id) {
            $.ajax({
                url: _baseUrl + '/sub-admin/resort/delete-resort-images',
                type: 'post',
                data: {record_id: record_id},
                dataType: 'json',
                beforeSend: function () {
                    $(".overlay").show();
                },
                success: function (res) {
                    if (res.status)
                    {
                        _this.parent("div").remove();
                        $(".overlay").hide();
                        showSuccessMessage(res.message);
                    } else {
                        $(".overlay").hide();
                        showErrorMessage(res.message);
                    }
                }
            });

        }
    });

    Dropzone.options.myDropzone = {
        init: function () {
            this.on("success", function (file, response) {
                if (response.status) {
                    var removeButton = Dropzone.createElement("<button style='margin-left: 22px;' class='btn btn-info btn-xs' id='" + response.id + "' data-val='" + response.file_name + "'>Remove file</button>");
                    var hidden_image_html = "<input id='resort_image_input_" + response.id + "' type='hidden' name='resort_images[]' value='" + response.file_name + "'>";
                    var _this = this;
                    removeButton.addEventListener("click", function (e) {
                        // Make sure the button click doesn't submit the form:
                        e.preventDefault();
                        e.stopPropagation();
                        var record_id = this.id;
                        var record_val = $(this).attr("data-val");
                        $.ajax({
                            url: _baseUrl + '/sub-admin/resort/delete-images',
                            type: 'post',
                            data: {record_val: record_val, record_id: record_id},
                            beforeSend: function () {
                                $(".overlay").show();
                            },
                            success: function (res) {
                                $("#resort_image_input_" + record_id).remove();
                                _this.removeFile(file);
                                $(".overlay").hide();
                                showSuccessMessage(res.message);
                            }
                        });


                    });
                    file.previewElement.appendChild(removeButton);
                    $("#resort_images_div").append(hidden_image_html);
                }
            });
        },
        dictDefaultMessage: "Drop or Select multiple images for resort."
    };
});

</script>    
@endsection
@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <h2>Add Resort</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <div class="form-horizontal form-label-left">
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">Images</label>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <form id="my-dropzone" class="dropzone" action="{{ route('admin.resort.upload-image') }}">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
                <div class="ln_solid"></div>
                <form class="form-horizontal form-label-left" action="{{ route('admin.resort.add') }}" method="post" id="addResortForm" enctype="multipart/form-data">
                    @csrf
                    <div id="resort_images_div"></div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('resort_name') }}" type="text" class="form-control" name="resort_name" id="resort_name" placeholder="Resort Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Contact Number</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('contact_no') }}" type="text" class="form-control" name="contact_no" id="contact_no" placeholder="Contact Number">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <textarea class="form-control" name="resort_description" id="resort_description" placeholder="Resort Description">{{ old('resort_description') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('address') }}" type="text" class="form-control" name="address" id="address" placeholder="Address">
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
                                        @if(old('state') == $state->id)
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
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Pincode</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('pin_code') }}" type="text" class="form-control" name="pin_code" id="pin_code" placeholder="Pincode">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Latitude</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('latitude') }}" type="text" class="form-control" name="latitude" id="latitude" placeholder="Latitude">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Longitude</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('longitude') }}" type="text" class="form-control" name="longitude" id="longitude" placeholder="Longitude">
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Amenities</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <p style="padding: 5px;">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input class="flat" type="checkbox" name="aminities[]" value="1">Wifi
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input class="flat" type="checkbox" name="aminities[]" value="2">Swimming Pool
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input class="flat" type="checkbox" name="aminities[]" value="3">Air Conditioner
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input class="flat" type="checkbox" name="aminities[]" value="4">Room Service
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input class="flat" type="checkbox" name="aminities[]" value="5">Restaurant
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input class="flat" type="checkbox" name="aminities[]" value="6">Bar
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input class="flat" type="checkbox" name="aminities[]" value="7">Gym/Fitness Center
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input class="flat" type="checkbox" name="aminities[]" value="8">Parking
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input class="flat" type="checkbox" name="aminities[]" value="9">Spa
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input class="flat" type="checkbox" name="aminities[]" value="10">Pets
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input class="flat" type="checkbox" name="aminities[]" value="11">Gyser
                                </div>
                            </div>
                            <p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Other Amenities</label>
                    </div>
                    <div id="other_amenity_div">
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
                        @if(old('room_no'))
                        @foreach(old('room_no') as $key => $old_room)
                        <div class='form-group'>
                            <label class='control-label col-md-2 col-sm-2 col-xs-12'>Room No.</label>
                            <div class='col-md-2 col-sm-2 col-xs-12'>
                                <input type='text' class='form-control' name='room_no[]'>
                            </div>
                            <label class='control-label col-md-3 col-sm-3 col-xs-12'>Room Type</label>
                            <div class = 'col-md-2 col-sm-2 col-xs-11'>
                                <select class='form-control' name='room_type[]' id='room_type'>
                                    @if($roomTypes)
                                    @foreach($roomTypes as $roomType)
                                    <option value="{{ $roomType->id }}">{{ $roomType->name }}"
                                        @if(old('room_type')[$key] == $roomType->id)
                                        {{ "selected" }}
                                        @endif
                                        ></option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <i style='cursor:pointer' class='fa fa-times delete_this_div'></i>
                        </div>
                        @endforeach
                        @endif

                    </div>
                    <div class="form-group">
                        <div class="col-md-2 col-sm-2 col-xs-12 col-md-offset-8 col-sm-offset-8 col-xs-offset-8">
                            <button type="button" class="btn btn-primary" id="add_more_room">Add Room</button>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                            <a class="btn btn-default" href="{{ route('admin.resort.index') }}">Cancel</a>
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
<script src="{{ asset("/vendor/unisharp/laravel-ckeditor/ckeditor.js") }}"></script>
<script>
$(document).ready(function () {

    if ($("input.flat")[0]) {
        $(document).ready(function () {
            $('input.flat').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            });
        });
    }

//For ckeditor
    CKEDITOR.replace('resort_description', {
        removeButtons: 'Cut,Copy,Paste,Undo,Redo,Anchor',
        removePlugins: 'image, link',
//        removePlugins: 'elementspath,save,image,flash,i frame,link,smiley,tabletools,find,pagebreak,templates,about,maximize,showblocks,newpage,language',
    });
    CKEDITOR.instances.resort_description.on('change', function () {
        if (CKEDITOR.instances.resort_description.getData().length > 0) {
            $('label[for="resort_description"]').hide();
        }
    });


    var roomTypes = <?php echo json_encode($roomTypes) ?>;
    var room_type = "<label class='control-label col-md-3 col-sm-3 col-xs-12'>Room Type</label><div class = 'col-md-2 col-sm-2 col-xs-11'><select class='form-control' name='room_type[]' id='room_type'>";
    $.each(roomTypes, function (key, val) {
        room_type += "<option value='" + val.id + "'>" + val.name + "</option>";
    });
    room_type += "</select></div>";


    $(document).on("click", "#add_more_room", function () {

        var member_html = "<div class='form-group'>"
                + "<label class='control-label col-md-2 col-sm-2 col-xs-12'>Room No.</label>"
                + "<div class='col-md-2 col-sm-2 col-xs-12'>"
                + "<input type='text' class='form-control' name='room_no[]'>"
                + "</div>" + room_type + "<i style='cursor:pointer' class='fa fa-times delete_this_div'></i></div>";
        $("#room_detail_div").append(member_html);
    });

    $(document).on("click", "#add_more_amenity", function () {

        var amenity_html = "<div class='form-group'>"
                + "<label class='control-label col-md-3 col-sm-6 col-xs-12'></label>"
                + "<div class='col-md-5 col-sm-5 col-xs-11'>"
                + "<input type='text' class='form-control' name='other_amenities[]'>"
                + "</div>"
                + "<i style='cursor:pointer' class='fa fa-times delete_this_div'></i>"
                + "</div>";
        $("#other_amenity_div").append(amenity_html);
    });


    Dropzone.options.myDropzone = {
        init: function () {
            this.on("success", function (file, response) {
                if (response.status) {
                    var removeButton = Dropzone.createElement("<button style='margin-left: 22px;' class='btn btn-danger btn-xs' id='" + response.id + "' data-val='" + response.file_name + "'>Remove file</button>");
                    var hidden_image_html = "<input id='resort_image_input_" + response.id + "' type='hidden' name='resort_images[]' value='" + response.file_name + "'>";
                    var _this = this;
                    removeButton.addEventListener("click", function (e) {
                        // Make sure the button click doesn't submit the form:
                        e.preventDefault();
                        e.stopPropagation();
                        var record_id = this.id;
                        var record_val = $(this).attr("data-val");
                        $.ajax({
                            url: _baseUrl + '/admin/resort/delete-images',
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
            this.on("error", function (file, message) {
                this.removeFile(file);
                showErrorMessage(message);
            });
        },
        maxFilesize: 2,
        acceptedMimeTypes: 'image/*',
        dictDefaultMessage: "Drop or Select multiple images for resort."
    };

    jQuery.validator.addMethod("float_number", function (value, element) {
        return this.optional(element) || /^[-+]?[0-9]+\.[0-9]+$/.test(value);
    }, "Please provide valid lat & long value.");

    $("#addResortForm").validate({
        ignore: [],
        rules: {
//            cktext: {
//                required: function ()
//                {
//                    CKEDITOR.instances.cktext.updateElement();
//                },
//            },
            resort_name: {
                required: true
            },
            contact_no: {
                required: true,
                number: true,
                minlength: 10,
                maxlength: 10,

            },
            address: {
                required: true
            },
            pin_code: {
                required: true,
                number: true,
                minlength: 6,
                maxlength: 6,
            },
            state: {
                required: true
            },
            city: {
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
        }
    });

    $(document).on("click", ".delete_this_div", function () {
        $(this).parent("div").remove();
    });

});
</script>
@endsection
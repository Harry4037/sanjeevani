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
                            <form id="my-dropzone" class="dropzone" action="{{ route('admin.resort.upload-image') }}">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
                <div class="ln_solid"></div>
                <form class="form-horizontal form-label-left" action="{{ route('admin.resort.edit', $data->id) }}" method="post" id="editResortForm" enctype="multipart/form-data">
                    @csrf
                    <div id="resort_images_div"></div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Resort Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="edit_resort_name" id="edit_resort_name" placeholder="Resort Name" value="{{ $data->name }}">
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Room Details</label>
                    </div>

                    <div id="room_detail_div">

                        @if($dataRooms)
                        @foreach($dataRooms as $dataRoom)
                        <div class='form-group'>
                            <label class='control-label col-md-2 col-sm-2 col-xs-12'>Room No.</label>
                            <div class='col-md-2 col-sm-2 col-xs-12'>
                                <input value="{{ $dataRoom->room_no }}" type='text' class='form-control' name='room_no[]'>
                            </div>
                            <label class='control-label col-md-3 col-sm-3 col-xs-12'>Room Type</label>                         
                            <div class = 'col-md-2 col-sm-2 col-xs-11'>
                                <select class='form-control' name='room_type[]' id='room_type'>
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
                            <a class="btn btn-default" href="{{ route('admin.resort.index') }}">Cancel</a>
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

    $("#editResortForm").validate({
        rules: {
            edit_resort_name: {
                required: true
            },
            edit_contact_no: {
                required: true,
                number: true
            },
            edit_resort_description: {
                required: true
            },
            edit_address: {
                required: true
            },
            edit_pin_code: {
                required: true
            },
            state: {
                required: true
            },
            city: {
                required: true
            }
        }
    });

    var roomTypes = <?php echo json_encode($roomTypes) ?>;

    var room_type = "<label class='control-label col-md-3 col-sm-3 col-xs-12'>Room Type</label><div class = 'col-md-2 col-sm-2 col-xs-2'><select class='form-control' name='room_type[]' id='room_type'>";
    $.each(roomTypes, function (key, val) {
        room_type += "<option value='" + val.id + "'>" + val.name + "</option>";
    });
    room_type += "</select></div>";
    $(document).on("click", "#add_more_room", function () {

        var member_html = "<div class='form-group'><label class='control-label col-md-2 col-sm-2 col-xs-2'>Room No.</label><div class='col-md-2 col-sm-2 col-xs-2'>"
                + "<input type='text' class='form-control' name='room_no[]'>"
                + "</div>" + room_type + "<i style='cursor:pointer' class='fa fa-times delete_this_div'></i></div>";
        $("#room_detail_div").append(member_html);
    });

    $(document).on("click", ".delete_this_div", function () {
        $(this).parent("div").remove();
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('click', '.delete_room', function () {
        var record_id = this.id;
        var _this = $(this);
        if (record_id) {
            $.ajax({
                url: _baseUrl + '/admin/resort/delete-room',
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
                    } else {
                        alert("Something went be wrong");
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
                url: _baseUrl + '/admin/resort/delete-resort-images',
                type: 'post',
                data: {record_id: record_id},
                dataType: 'json',
                success: function (res) {
                    if (res.status)
                    {
                        _this.parent("div").remove();
                    } else {
                        alert("Something went be wrong");
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
                            url: _baseUrl + '/admin/resort/delete-images',
                            type: 'post',
                            data: {record_val: record_val, record_id: record_id},
//                            dataType: 'json',
                            success: function (res) {
                                console.log(res);
                                $("#resort_image_input_" + record_id).remove();
                                _this.removeFile(file);
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
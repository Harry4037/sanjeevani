@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <h2>Edit Nearby</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <div class="form-horizontal form-label-left">
                    @if($nearbyImages)
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12"></label>
                        @foreach($nearbyImages as $nearbyImage)
                        <div class="col-md-2 col-sm-2 col-xs-6">
                            <img src="{{ $nearbyImage->name }}" class="img-pre">
                            <button style="margin-left: 40px;" class="btn btn-danger btn-xs delete_nearby_image" id="{{ $nearbyImage->id }}" >Remove</button>
                        </div>
                        @endforeach
                    </div>
                    @endif
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">Nearby Images</label>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <form id="my-dropzone" class="dropzone" action="{{ route('admin.nearby.upload-image') }}">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
                <div class="ln_solid"></div>
                <form class="form-horizontal form-label-left" action="{{ route('admin.nearby.edit', $data->id) }}" method="post" id="editNearbyForm" >
                    @csrf
                    <div id="nearby_images_div"></div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Resort*</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="resort_id" id="resort_id">
                                <option value="">Choose option</option>
                                @if($resorts)
                                @foreach($resorts as $resort)
                                <option value="{{ $resort->id }}" @if($resort->id == $data->resort_id ){{ "selected" }} @endif>{{ $resort->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Place Name*</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" class="form-control" name="place_name" id="place_name" placeholder="Place Name" value="{{ $data->name }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Distance From Resort*</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="number" class="form-control" name="distance" id="distance" placeholder="Distance From Resort (in KM)" value="{{ $data->distance_from_resort }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Place Description</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <textarea class="form-control" name="place_description" id="place_description" placeholder="Place Description">{{ $data->description }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Precautions</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <textarea class="form-control" name="place_precaution" id="place_precaution" placeholder="Place Precaution">{{ $data->precautions }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Address*</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" class="form-control" name="address" id="address" placeholder="Address" value="{{ $data->address_1 }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">State*</label>
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">City*</label>
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Pincode*</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input value="{{ $data->pincode }}" type="text" class="form-control" name="pin_code" id="pin_code" placeholder="Pincode">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Latitude*</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input value="{{ $data->latitude }}" type="text" class="form-control" name="latitude" id="latitude" placeholder="Latitude">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Longitude*</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input value="{{ $data->longitude }}" type="text" class="form-control" name="longitude" id="longitude" placeholder="Longitude">
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-4">
                            <a class="btn btn-default" href="{{ route('admin.nearby.index') }}">Cancel</a>
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
    CKEDITOR.replace('place_description', {
        removeButtons: 'Cut,Copy,Paste,Undo,Redo,Anchor',
        removePlugins: 'image, link',
    });
    CKEDITOR.replace('place_precaution', {
        removeButtons: 'Cut,Copy,Paste,Undo,Redo,Anchor',
        removePlugins: 'image, link',
    });

    jQuery.validator.addMethod("float_number", function (value, element) {
        return this.optional(element) || /^[-+]?[0-9]+\.[0-9]+$/.test(value);
    }, "Please provide valid float value");

    $("#editNearbyForm").validate({
        rules: {
            resort_id: {
                required: true
            },
            place_name: {
                required: true
            },
            distance: {
                required: true,
                number: true
            },
//            place_description: {
//                required: true
//            },
//            place_precaution: {
//                required: true
//            },
            address: {
                required: true
            },
            pin_code: {
                required: true,
                number: true,
                maxlength: 6,
                minlength: 6,
            },
            state: {
                required: true
            },
            district: {
                required: true
            },
            city: {
                required: true
            },
            latitude: {
                required: true,
                number: true,
                float_number: true
            },
            longitude: {
                required: true,
                number: true,
                float_number: true
            },
        }
    });

    Dropzone.options.myDropzone = {
        init: function () {
            this.on("success", function (file, response) {
                if (response.status) {
                    var removeButton = Dropzone.createElement("<button style='margin-left: 22px;' class='btn btn-danger btn-xs' id='" + response.id + "' data-val='" + response.file_name + "'>Remove file</button>");
                    var hidden_image_html = "<input id='nearby_image_input_" + response.id + "' type='hidden' name='nearby_images[]' value='" + response.file_name + "'>";
                    var _this = this;
                    removeButton.addEventListener("click", function (e) {
                        // Make sure the button click doesn't submit the form:
                        e.preventDefault();
                        e.stopPropagation();
                        var record_id = this.id;
                        var record_val = $(this).attr("data-val");
                        $.ajax({
                            url: _baseUrl + '/admin/nearby/delete-images',
                            type: 'post',
                            data: {record_val: record_val, record_id: record_id},
                            beforeSend: function () {
                                $(".overlay").show();
                            },
                            success: function (res) {
                                $("#nearby_image_input_" + record_id).remove();
                                _this.removeFile(file);
                                showSuccessMessage(res.message);
                                $(".overlay").hide();
                            }
                        });

                    });
                    file.previewElement.appendChild(removeButton);
                    $("#nearby_images_div").append(hidden_image_html);
                }
            });
            this.on("error", function (file, message) {
                showErrorMessage(message);
                this.removeFile(file);
            });
        },
        maxFilesize: 2,
        acceptedMimeTypes: 'image/*',
        dictDefaultMessage: "Drop or Select multiple images for nearny images."
    };

    $(document).on('click', '.delete_nearby_image', function () {
        var record_id = this.id;
        var _this = $(this);
        if (record_id) {
            $.ajax({
                url: _baseUrl + '/admin/nearby/delete-nearby-images',
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
                        showSuccessMessage(res.message);
                        $(".overlay").hide();
                    } else {
                        showErrorMessage(res.message);
                        $(".overlay").hide();
                    }
                }
            });

        }
    });
});



</script>
@endsection
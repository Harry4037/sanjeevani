@extends('layouts.subadmin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <h2>Add Nearby</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <div class="form-horizontal form-label-left">
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">Images</label>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <form id="my-dropzone" class="dropzone" action="{{ route('subadmin.nearby.upload-image') }}">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
                <div class="ln_solid"></div>
                <form class="form-horizontal form-label-left" action="{{ route('subadmin.nearby.add') }}" method="post" id="addNearbyForm" >
                    @csrf
                    <div id="nearby_images_div"></div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Place Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" class="form-control" name="place_name" id="place_name" placeholder="Place Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Distance From Resort</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="number" class="form-control" name="distance" id="distance" placeholder="Distance From Resort (in KM)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Place Description</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <textarea class="form-control" name="place_description" id="place_description" placeholder="Place Description"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Precautions</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <textarea class="form-control" name="place_precaution" id="place_precaution" placeholder="Place Precaution"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" class="form-control" name="address" id="address" placeholder="Address">
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
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" class="form-control" name="pin_code" id="pin_code" placeholder="Pincode">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Latitude</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" class="form-control" name="latitude" id="latitude" placeholder="Latitude">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Longitude</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" class="form-control" name="longitude" id="longitude" placeholder="Longitude">
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                            <a class="btn btn-default" href="{{ route('subadmin.room.index') }}">Cancel</a>
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

//For ckeditor
    CKEDITOR.replace('place_description', {
        removeButtons: 'Cut,Copy,Paste,Undo,Redo,Anchor',
        removePlugins: 'image, link',
    });
    CKEDITOR.replace('place_precaution', {
        removeButtons: 'Cut,Copy,Paste,Undo,Redo,Anchor',
        removePlugins: 'image, link',
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
                            url: _baseUrl + '/sub-admin/nearby/delete-images',
                            type: 'post',
                            data: {record_val: record_val, record_id: record_id},
                            success: function (res) {
                                $("#nearby_image_input_" + record_id).remove();
                                _this.removeFile(file);
                            }
                        });

                    });
                    file.previewElement.appendChild(removeButton);
                    $("#nearby_images_div").append(hidden_image_html);
                }
            });
            this.on("error", function (file, message) {
                alert(message);
                this.removeFile(file);
            });

        },
        maxFilesize: 2,
        acceptedMimeTypes: 'image/*',
        dictDefaultMessage: "Drop or Select multiple images for nearny images."
    };

    $("#addNearbyForm").validate({
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
//                place_description: {
//                    required: true
//                },
//                place_precaution: {
//                    required: true
//                },
            address: {
                required: true
            },
            pin_code: {
                required: true
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
                required: true
            },
            longitude: {
                required: true
            },
        }
    });
});



</script>
@endsection
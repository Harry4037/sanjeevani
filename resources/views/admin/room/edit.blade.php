@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <h2>Edit Room Type</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <div class="form-horizontal form-label-left">
                    @if($roomImages)
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12"></label>
                        @foreach($roomImages as $roomImage)
                        <div class="col-md-2 col-sm-2 col-xs-6">
                            <img src="{{ $roomImage->image_name }}" class="img-rounded img-pre">
                            <button style="margin-left: 40px;" class="btn btn-info btn-xs delete_room_image" id="{{ $roomImage->id }}" >Remove</button>
                        </div>
                        @endforeach
                    </div>
                    @endif
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">Images</label>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <form id="my-dropzone" class="dropzone" action="{{ route('admin.room.upload-image') }}">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
                <div class="ln_solid"></div>
                <form class="form-horizontal form-label-left" action="{{ route('admin.room.edit', $data->id) }}" method="post" id="editRoomForm" enctype="multipart/form-data">
                    @csrf
                    <div id="room_images_div"></div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ $data->name }}" type="text" class="form-control" name="name" id="name" placeholder="Room Type">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Icon</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="file" class="form-control" name="room_icon" id="room_icon">
                        </div>
                    </div>
                    @if($data->icon)
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Icon Preview</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <img src="{{ $data->icon }}" style="height: 50px; width: 50px;border: 1px bold #7b7b7b;">
                        </div>
                    </div>
                    @endif
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <textarea class="form-control" name="description" id="description" placeholder="Description">{{ $data->description }}</textarea>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                            <a class="btn btn-default" href="{{ route('admin.room.index') }}">Cancel</a>
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

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

//For ckeditor
    CKEDITOR.replace('description', {
        removeButtons: 'Cut,Copy,Paste,Undo,Redo,Anchor',
        removePlugins: 'image, link',
    });

    $("#editRoomForm").validate({
        ignore: [],
        rules: {
            name: {
                required: true
            },
        }
    });

    $(document).on('click', '.delete_room_image', function () {
        var record_id = this.id;
        var _this = $(this);
        if (record_id) {
            $.ajax({
                url: _baseUrl + '/admin/room-type/delete-room-images',
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
                    var hidden_image_html = "<input id='room_image_input_" + response.id + "' type='hidden' name='room_images[]' value='" + response.file_name + "'>";
                    var _this = this;
                    removeButton.addEventListener("click", function (e) {

                        // Make sure the button click doesn't submit the form:
                        e.preventDefault();
                        e.stopPropagation();
                        var record_id = this.id;
                        var record_val = $(this).attr("data-val");

                        $.ajax({
                            url: _baseUrl + '/admin/room-type/delete-images',
                            type: 'post',
                            data: {record_val: record_val, record_id: record_id},
                            success: function (res) {
                                console.log(res);
                                $("#room_image_input_" + record_id).remove();
                                _this.removeFile(file);
                            }
                        });


                    });
                    file.previewElement.appendChild(removeButton);
                    $("#room_images_div").append(hidden_image_html);
                }
            });
            this.on("error", function (file, message) {
                alert(message);
                this.removeFile(file);
            });
        },
        maxFilesize: 2,
        acceptedMimeTypes: 'image/*',
        dictDefaultMessage: "Drop or Select multiple images for room type images."
    };

});
</script>
@endsection
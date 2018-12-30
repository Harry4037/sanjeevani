@extends('layouts.subadmin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <h2>Add Amenity</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <div class="form-horizontal form-label-left">
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">Amenity Images</label>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <form id="my-dropzone" class="dropzone" action="{{ route('subadmin.amenity.upload-image') }}">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
                <div class="ln_solid"></div>
                <form class="form-horizontal form-label-left" action="{{ route('subadmin.amenity.add') }}" method="post" id="addAmenityForm" enctype="multipart/form-data">
                    @csrf
                    <div id="amenity_images_div"></div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Amenity Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('amenity_name') }}" type="text" class="form-control" name="amenity_name" id="amenity_name" placeholder="Amenity Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Amenity Description</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <textarea class="form-control" name="amenity_description" id="amenity_description" placeholder="Amenity Description">{{ old('amenity_description') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <textarea class="form-control" name="address" id="address" placeholder="Address">{{ old('address') }}</textarea>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Add Time Slots</label>
                    </div>

                    <div id="time_slot_div">
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
                        <div class="col-md-2 col-sm-2 col-xs-12 col-md-offset-10 col-sm-offset-10 col-xs-offset-10">
                            <button type="button" class="btn btn-primary" id="add_time_slot">Add Slot</button>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                            <a class="btn btn-default" href="{{ route('subadmin.amenity.index') }}">Cancel</a>
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

    $(document).on('focus', ".from_timepicker", function () {
        $(this).daterangepicker({
            timePicker: true,
//            timePicker24Hour: true,
            timePickerIncrement: 1,
            timePickerSeconds: true,
            locale: {
                format: 'hh:mm:ss A'
            },
            singleDatePicker: true,
            singleClasses: "picker_3",
        }).on('show.daterangepicker', function (ev, picker) {
            picker.container.find(".calendar-table").hide();
        });
    });

    $(document).on('focus', ".to_timepicker", function () {
        $(this).daterangepicker({
            timePicker: true,
//            timePicker24Hour: true,
            timePickerIncrement: 1,
            timePickerSeconds: true,
            locale: {
                format: 'hh:mm:ss A'
            },
            singleDatePicker: true,
            singleClasses: "picker_3",
        }).on('show.daterangepicker', function (ev, picker) {
            picker.container.find(".calendar-table").hide();
        });
    });



//For ckeditor
    CKEDITOR.replace('amenity_description', {
        removeButtons: 'Cut,Copy,Paste,Undo,Redo,Anchor',
        removePlugins: 'image, link',
//        removePlugins: 'elementspath,save,image,flash,i frame,link,smiley,tabletools,find,pagebreak,templates,about,maximize,showblocks,newpage,language',
    });
    CKEDITOR.instances.amenity_description.on('change', function () {
        if (CKEDITOR.instances.resort_description.getData().length > 0) {
            $('label[for="amenity_description"]').hide();
        }
    });


    $(document).on("click", "#add_time_slot", function () {

        var html = "<div class='form-group'>\n\
                <label class='control-label col-md-2 col-sm-2 col-xs-12'>From</label>\n\
                <div class='col-md-2 col-sm-2 col-xs-12'>"
                + "<input readonly type='text' class='form-control from_timepicker' name='from_time[]' >"
                + "</div>\n\
            <label class='control-label col-md-1 col-sm-1 col-xs-12'>To</label>\n\
            <div class = 'col-md-2 col-sm-2 col-xs-12'>"
                + "<input readonly type='text' class='form-control to_timepicker' name='to_time[]'>"
                + "</div>"
                + "<label class='control-label col-md-2 col-sm-2 col-xs-12'>Total People</label>\n\
            <div class = 'col-md-2 col-sm-2 col-xs-10'>"
                + "<input type='number' class='form-control' name='total_people[]'>"
                + "</div>"
                + "<i style='cursor:pointer' class='fa fa-times delete_this_div'></i></div>";
        $("#time_slot_div").append(html);
    });

    Dropzone.options.myDropzone = {
        init: function () {
            this.on("success", function (file, response) {
                if (response.status) {
                    var removeButton = Dropzone.createElement("<button style='margin-left: 22px;' class='btn btn-info btn-xs' id='" + response.id + "'>Remove file</button>");
                    var hidden_image_html = "<input id='amenity_image_input_" + response.file_name + "' type='hidden' name='amenity_images[]' value='" + response.file_name + "'>";
                    var _this = this;
                    removeButton.addEventListener("click", function (e) {
                        // Make sure the button click doesn't submit the form:
                        e.preventDefault();
                        e.stopPropagation();
                        var record_id = this.id;
                        $("#amenity_image_input_" + record_id).remove();
                        _this.removeFile(file);
                    });
                    file.previewElement.appendChild(removeButton);
                    $("#amenity_images_div").append(hidden_image_html);
                }
            });
            this.on("error", function (file, message) {
                alert(message);
                this.removeFile(file);
            });
        },
        maxFilesize: 2,
        acceptedMimeTypes: 'image/*',
        dictDefaultMessage: "Drop or Select multiple images for amenity."
    };

    $("#addAmenityForm").validate({
        ignore: [],
        rules: {
//            cktext: {
//                required: function ()
//                {
//                    CKEDITOR.instances.cktext.updateElement();
//                },
//            },
            resort_id: {
                required: true
            },
            amenity_name: {
                required: true
            },
            address: {
                required: true
            },
        }
    });

    $(document).on("click", ".delete_this_div", function () {
        $(this).parent("div").remove();
    });

});
</script>
@endsection
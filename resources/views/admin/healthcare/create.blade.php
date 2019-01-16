@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <h2>Add Healthcare Package</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <div class="form-horizontal form-label-left">
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">Healthcare Package Images</label>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <form id="my-dropzone" class="dropzone" action="{{ route('admin.healthcare.upload-image') }}">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
                <div class="ln_solid"></div>
                <form class="form-horizontal form-label-left" action="{{ route('admin.healthcare.add') }}" method="post" id="addHealthcareForm" enctype="multipart/form-data">
                    @csrf
                    <div id="healthcare_images_div"></div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Resort</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="resort_id" name="resort_id">
                                <option value="">Select option</option>
                                @if($resorts)
                                @foreach($resorts as $resort)
                                <option value="{{ $resort->id }}">{{ $resort->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Package Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('package_name') }}" type="text" class="form-control" name="package_name" id="package_name" placeholder="Package Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Start From</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input readonly value="{{ old('start_from') }}" type="text" class="form-control" name="start_from" id="start_from" placeholder="Start From">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">End To</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input readonly value="{{ old('end_to') }}" type="text" class="form-control" name="end_to" id="end_to" placeholder="End To">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Package Description</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <textarea class="form-control" name="package_description" id="package_description" placeholder="Package Description">{{ old('package_description') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Days</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="day_id" name="day_id">
                                <option value="">Select option</option>
                                <option value="21">21 days</option>
                                <option value=14"">14 days</option>
                                <option value="7">7 days</option>
                                <option value="3">3 days</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Add Days Description</label>
                    </div>
                    <div class="ln_solid"></div>
                    <div id="days_div">

                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                            <a class="btn btn-default" href="{{ route('admin.healthcare.index') }}">Cancel</a>
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

    $('#start_from').daterangepicker({
        singleDatePicker: true,
        timePicker: false,
        singleClasses: "picker_1",
        minDate: new Date(),
        locale: {
            format: 'YYYY/M/DD'
        }
    }, function (start, end, label) {
        $('#end_to').daterangepicker({
            minDate: start,
            singleDatePicker: true,
            timePicker: false,
            singleClasses: "picker_1",
            locale: {
                format: 'YYYY/M/DD'
            }
        });
    });
    $('#end_to').daterangepicker({
        singleDatePicker: true,
        timePicker: false,
        singleClasses: "picker_1",
        minDate: moment().startOf('hour').add(24, 'hour'),
        locale: {
            format: 'YYYY/M/DD'
        }
    });


    $(document).on("change", "#day_id", function () {
        var days = parseInt($("#day_id :selected").val());
        var i;
        $("#days_div").html('');
        for (i = 0; i < days; i++) {
            var day_html = '<div class="form-group">'
                    + '<label class="control-label col-md-3 col-sm-3 col-xs-12">Day ' + (i + 1) + '</label>'
                    + '<div class="col-md-8 col-sm-8 col-xs-12">'
                    + '<textarea class="form-control" name="day_description[]" id="day_description_' + i + '" placeholder="Day description"></textarea>'
                    + '</div>'
                    + '</div>';
            $("#days_div").append(day_html);
            CKEDITOR.replace('day_description_' + i, {
                removeButtons: 'Cut,Copy,Paste,Undo,Redo,Anchor',
                removePlugins: 'image, link',
            });
        }

    });

//For ckeditor
    CKEDITOR.replace('package_description', {
        removeButtons: 'Cut,Copy,Paste,Undo,Redo,Anchor',
        removePlugins: 'image, link',
//        removePlugins: 'elementspath,save,image,flash,i frame,link,smiley,tabletools,find,pagebreak,templates,about,maximize,showblocks,newpage,language',
    });
    CKEDITOR.instances.package_description.on('change', function () {
        if (CKEDITOR.instances.resort_description.getData().length > 0) {
            $('label[for="package_description"]').hide();
        }
    });

    Dropzone.options.myDropzone = {
        init: function () {
            this.on("success", function (file, response) {
                if (response.status) {
                    var removeButton = Dropzone.createElement("<button style='margin-left: 22px;' class='btn btn-info btn-xs' id='" + response.id + "' data-val='" + response.file_name + "'>Remove file</button>");
                    var hidden_image_html = "<input id='healthcare_image_input_" + response.id + "' type='hidden' name='healthcare_images[]' value='" + response.file_name + "'>";
                    var _this = this;
                    removeButton.addEventListener("click", function (e) {
                        // Make sure the button click doesn't submit the form:
                        e.preventDefault();
                        e.stopPropagation();
                        var record_id = this.id;
                        var record_val = $(this).attr("data-val");
                        $.ajax({
                            url: _baseUrl + '/admin/healthcare/delete-images',
                            type: 'post',
                            data: {record_val: record_val, record_id: record_id},
//                            dataType: 'json',
                            success: function (res) {
                                $("#healthcare_image_input_" + record_id).remove();
                                _this.removeFile(file);
                            }
                        });
                    });
                    file.previewElement.appendChild(removeButton);
                    $("#healthcare_images_div").append(hidden_image_html);
                }
            });
            this.on("error", function (file, message) {
                alert(message);
                this.removeFile(file);
            });
        },
        maxFilesize: 2,
        acceptedMimeTypes: 'image/*',
        dictDefaultMessage: "Drop or Select multiple images for healthcare packages."
    };

    $("#addHealthcareForm").validate({
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
            package_name: {
                required: true
            },
            day_id: {
                required: true
            },
        }
    });

});
</script>
@endsection
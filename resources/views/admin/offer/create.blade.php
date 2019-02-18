@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <h2>Add Offer</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <div class="form-horizontal form-label-left">
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">Offer Images</label>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <form id="my-dropzone" class="dropzone" action="{{ route('admin.offer.upload-image') }}">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
                <div class="ln_solid"></div>
                <form class="form-horizontal form-label-left" action="{{ route('admin.offer.add') }}" method="post" id="addOfferForm" enctype="multipart/form-data">
                    @csrf
                    <div id="offer_images_div"></div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Resort*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="resort_id" name="resort_id">
                                <option value="">Select option</option>
                                <option value="-1">Generalized Offer</option>
                                @if($resorts)
                                @foreach($resorts as $resort)
                                <option value="{{ $resort->id }}">{{ $resort->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Offer Name*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('offer_name') }}" type="text" class="form-control" name="offer_name" id="offer_name" placeholder="Offer Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Price*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('price') }}" type="number" class="form-control" name="price" id="price" placeholder="Price">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Discount*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('discount') }}" type="number" class="form-control" name="discount" id="discount" placeholder="Discount">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Valid To*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input readonly value="{{ old('valid_to') }}" type="text" class="form-control" name="valid_to" id="valid_to" placeholder="Valid To">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Offer Description</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <textarea class="form-control" name="offer_description" id="offer_description" placeholder="Offer Description">{{ old('offer_description') }}</textarea>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                            <a class="btn btn-default" href="{{ route('admin.offer.index') }}">Cancel</a>
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

    $('#valid_to').daterangepicker({
        singleDatePicker: true,
        timePicker: false,
        singleClasses: "picker_1",
        minDate: new Date(),
        locale: {
            format: 'YYYY/M/DD'
        }
    });


//For ckeditor
    CKEDITOR.replace('offer_description', {
        removeButtons: 'Cut,Copy,Paste,Undo,Redo,Anchor',
        removePlugins: 'image, link',
    });
    CKEDITOR.instances.offer_description.on('change', function () {
        if (CKEDITOR.instances.offer_description.getData().length > 0) {
            $('label[for="offer_description"]').hide();
        }
    });

    Dropzone.options.myDropzone = {
        init: function () {
            this.on("success", function (file, response) {
                if (response.status) {
                    var removeButton = Dropzone.createElement("<button style='margin-left: 22px;' class='btn btn-danger btn-xs' id='" + response.id + "' data-val='" + response.file_name + "'>Remove file</button>");
                    var hidden_image_html = "<input id='offer_image_input_" + response.id + "' type='hidden' name='offer_images[]' value='" + response.file_name + "'>";
                    var _this = this;
                    removeButton.addEventListener("click", function (e) {
                        // Make sure the button click doesn't submit the form:
                        e.preventDefault();
                        e.stopPropagation();
                        var record_id = this.id;
                        var record_val = $(this).attr("data-val");
                        $.ajax({
                            url: _baseUrl + '/admin/offer/delete-images',
                            type: 'post',
                            data: {record_val: record_val, record_id: record_id},
                            beforeSend: function () {
                                $(".overlay").show();
                            },
                            success: function (res) {
                                $("#offer_image_input_" + record_id).remove();
                                _this.removeFile(file);
                                $(".overlay").hide();
                                showSuccessMessage(res.message);
                            }
                        });
                    });
                    file.previewElement.appendChild(removeButton);
                    $("#offer_images_div").append(hidden_image_html);
                }
            });
            this.on("error", function (file, message) {
                showErrorMessage(message);
                this.removeFile(file);
            });
        },
        maxFilesize: 2,
        acceptedMimeTypes: 'image/*',
        dictDefaultMessage: "Drop or Select multiple images for offer."
    };

    $("#addOfferForm").validate({
        ignore: [],
        rules: {
            resort_id: {
                required: true
            },
            offer_name: {
                required: true
            },
            price: {
                required: true,
                number: true
            },
            discount: {
                required: true,
                number: true,
                range: [0, 100]
            },
            valid_to: {
                required: true
            },
        }
    });


});
</script>
@endsection
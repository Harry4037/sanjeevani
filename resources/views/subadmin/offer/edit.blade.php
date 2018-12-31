@extends('layouts.subadmin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <h2>Edit Offer</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <div class="form-horizontal form-label-left">
                    @if($amenityImages)
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12"></label>
                        @foreach($amenityImages as $roomImage)
                        <div class="col-md-2 col-sm-2 col-xs-6">
                            <img src="{{ $roomImage->image_name }}" class="img-rounded img-pre">
                            <button style="margin-left: 40px;" class="btn btn-info btn-xs delete_offer_image" id="{{ $roomImage->id }}" >Remove</button>
                        </div>
                        @endforeach
                    </div>
                    @endif
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">Offer Images</label>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <form id="my-dropzone" class="dropzone" action="{{ route('subadmin.offer.upload-image') }}">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
                <div class="ln_solid"></div>
                <form class="form-horizontal form-label-left" action="{{ route('subadmin.offer.edit', $amenity->id) }}" method="post" id="addOfferForm" enctype="multipart/form-data">
                    @csrf
                    <div id="offer_images_div"></div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Offer Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ $amenity->name }}" type="text" class="form-control" name="offer_name" id="offer_name" placeholder="Offer Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Price</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ $amenity->price }}" type="number" class="form-control" name="price" id="price" placeholder="Price">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Discount</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ $amenity->discount_percentage }}" type="number" class="form-control" name="discount" id="discount" placeholder="Discount">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Valid To</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input readonly type="text" class="form-control" name="valid_to" id="valid_to" placeholder="Valid To">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Offer Description</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <textarea class="form-control" name="offer_description" id="offer_description" placeholder="Offer Description">{{ $amenity->description }}</textarea>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                            <a class="btn btn-default" href="{{ route('subadmin.offer.index') }}">Cancel</a>
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

    $('#valid_to').daterangepicker({
        singleDatePicker: true,
        timePicker: false,
        singleClasses: "picker_1",
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
                    var removeButton = Dropzone.createElement("<button style='margin-left: 22px;' class='btn btn-info btn-xs' id='" + response.id + "' data-val='" + response.file_name + "'>Remove file</button>");
                    var hidden_image_html = "<input id='offer_image_input_" + response.id + "' type='hidden' name='offer_images[]' value='" + response.file_name + "'>";
                    var _this = this;
                    removeButton.addEventListener("click", function (e) {
                        // Make sure the button click doesn't submit the form:
                        e.preventDefault();
                        e.stopPropagation();
                        var record_id = this.id;
                        var record_val = $(this).attr("data-val");
                        $.ajax({
                            url: _baseUrl + '/sub-admin/offer/delete-images',
                            type: 'post',
                            data: {record_val: record_val, record_id: record_id},
//                            dataType: 'json',
                            success: function (res) {
                                $("#offer_image_input_" + record_id).remove();
                                _this.removeFile(file);
                            }
                        });
                    });
                    file.previewElement.appendChild(removeButton);
                    $("#offer_images_div").append(hidden_image_html);
                }
            });
            this.on("error", function (file, message) {
                alert(message);
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
                required: true
            },
            discount: {
                required: true
            },
            valid_to: {
                required: true
            },
        }
    });

    $(document).on('click', '.delete_offer_image', function () {
        var record_id = this.id;
        var _this = $(this);
        if (record_id) {
            $.ajax({
                url: _baseUrl + '/sub-admin/offer/delete-offer-images',
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

});
</script>
@endsection
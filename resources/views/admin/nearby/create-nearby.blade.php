@extends('layouts.admin.app')

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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nearby Images</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <form id="my-dropzone" class="dropzone" action="{{ route('admin.nearby.upload-image') }}">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
                <form class="form-horizontal form-label-left" action="{{ route('admin.nearby.add', $resort->id) }}" method="post" id="addNearbyForm" >
                    @csrf
                    <div id="nearby_images_div"></div>
                    <input type="hidden" name="resort_id" id="resort_id" value="{{ $resort->id }}">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Place Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" class="form-control" name="place_name" id="place_name" placeholder="Place Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Distance From Resort</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" class="form-control" name="distance" id="distance" placeholder="Distance From Resort (in KM)">
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Pincode</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" class="form-control" name="pin_code" id="pin_code" placeholder="Pincode">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">State</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="state" id="state">
                                <option value="">Choose option</option>
                                <option value="1">UP</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">District</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="district" id="district">
                                <option value="">Choose option</option>
                                <option value="1">Noida</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">City</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="city" id="city">
                                <option value="">Choose option</option>
                                <option value="1">Sector 66</option>
                                <option value="2">Sector 22</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div id="map"></div>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                            <!--                            <button type="button" class="btn btn-primary">Cancel</button>-->
                            <button type="reset" class="btn btn-primary">Reset</button>
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
<script>
    $(document).ready(function () {
        Dropzone.options.myDropzone = {
            init: function () {
                this.on("success", function (file, response) {
                    if (response.status) {
                        var removeButton = Dropzone.createElement("<button style='margin-left: 22px;' class='btn btn-danger btn-xs' id='" + response.id + "'>Remove file</button>");
                        var hidden_image_html = "<input id='nearby_image_input_" + response.id + "' type='hidden' name='nearby_images[]' value='" + response.file_name + "'>";
                        var _this = this;
                        removeButton.addEventListener("click", function (e) {
                            // Make sure the button click doesn't submit the form:
                            e.preventDefault();
                            e.stopPropagation();
                            var record_id = this.id;
                            $("#nearby_image_input_" + record_id).remove();
                            _this.removeFile(file);

                        });
                        file.previewElement.appendChild(removeButton);
                        $("#nearby_images_div").append(hidden_image_html);
                    }
                });
            }
        };

        $("#addNearbyForm").validate({
            rules: {
                place_name: {
                    required: true
                },
                distance: {
                    required: true,
                    number: true
                },
                place_description: {
                    required: true
                },
                place_precaution: {
                    required: true
                },
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

            }
        });
    });



</script>
@endsection
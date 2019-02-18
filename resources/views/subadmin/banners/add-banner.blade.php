@extends('layouts.subadmin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <h2>Add Banner</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>

                <form class="form-horizontal form-label-left" action="{{ route('subadmin.banner.add') }}" method="post" id="addBannerForm" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Banner*</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="file" class="form-control" name="banner_image" id="banner_image">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Is Active*</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="banner_status" id="banner_status">
                                <option value="">Choose option</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                            <a class="btn btn-default" href="{{ route('subadmin.banner.index') }}">Cancel</a>
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


        $("#addBannerForm").validate({
            rules: {
//                resort_id: {
//                    required: true
//                },
                banner_image: {
                    required: true,
                    accept: "image/*",
                },
                banner_status: {
                    required: true
                },
            },
            messages: {
                banner_image: {
                    accept: "Not valid image type"
                }
            }
        });
    });
</script>

@endsection

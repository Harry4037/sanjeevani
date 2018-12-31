@extends('layouts.subadmin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <h2>Add Meal</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <form class="form-horizontal form-label-left" action="{{ route('subadmin.meal-package.add') }}" method="post" id="addMealpackageForm" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Meal Package Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('name') }}" type="text" class="form-control" name="name" id="name" placeholder="Meal Package Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Price</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('price') }}" type="text" class="form-control" name="price" id="price" placeholder="Meal Package Price">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Meal Type</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="category" name="category">
                                <option value="">Select option</option>
                                <option value="V">Veg</option>
                                <option value="N">Non Veg</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Meal Package Image</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="file" class="form-control" name="image_name" id="image_name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Meal Items</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div id="resort_meal_items">
                            </div>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                            <a class="btn btn-default" href="{{ route('subadmin.meal-package.index') }}">Cancel</a>
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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#addMealpackageForm").validate({
            ignore: [],
            rules: {
                name: {
                    required: true
                },
                price: {
                    required: true
                },
                category: {
                    required: true
                },
                resort_id: {
                    required: true
                },
                image_name: {
                    required: true,
                    accept: "image/*"
                },
            },
            messages:{
                image_name: {
                    accept: "Please select valid type file image."
                }
            }
        });

        $(document).on("change", "#resort_id", function () {
            var record_id = $("#resort_id :selected").val();
            if (record_id) {
                $.ajax({
                    url: _baseUrl + '/sub-admin/meal-package/meal-items',
                    type: 'post',
                    data: {record_id: record_id},
                    dataType: 'html',
                    success: function (res) {
                        $("#resort_meal_items").html(res);
                    }
                });
            }
        });
    });
</script>
@endsection
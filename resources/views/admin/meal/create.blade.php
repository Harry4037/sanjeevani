@extends('layouts.admin.app')

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
                <form class="form-horizontal form-label-left" action="{{ route('admin.meal.add') }}" method="post" id="addMealForm" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Resort*</label>
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Meal Name*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('meal_name') }}" type="text" class="form-control" name="meal_name" id="meal_name" placeholder="Meal Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea class="form-control" name="description" id="description" placeholder="Description">{{ old('description') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Meal Price*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('meal_price') }}" type="number" class="form-control" name="meal_price" id="meal_price" placeholder="Meal Price">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Meal Category*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="meal_category_id" name="meal_category_id">
                                <option value="">Select option</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Meal Type*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="meal_type" name="meal_type">
                                <option value="">Select option</option>
                                <option value="D">Drinks</option>
                                <option value="V">Veg</option>
                                <option value="N">Non Veg</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Meal Image*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input accept="image/*" type="file" class="form-control" name="meal_image" id="meal_image">
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                            <a class="btn btn-default" href="{{ route('admin.meal.index') }}">Cancel</a>
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

        $("#addMealForm").validate({
            ignore: [],
            rules: {
                resort_id: {
                    required: true
                },
                meal_name: {
                    required: true
                },
                meal_price: {
                    required: true,
                    number: true
                },
                meal_category_id: {
                    required: true
                },
                meal_type: {
                    required: true
                },
                meal_image: {
                    required: true,
                    accept: "image/*"
                },
            },
            messages: {
                meal_image: {
                    accept: "Please select valid image type."
                },
            }
        });

        $(document).on('change', '#resort_id', function () {
            var resort_id = $("#resort_id :selected").val();
            $.ajax({
                url: _baseUrl + '/admin/meal-category/resort-meal-category/' + resort_id,
                type: 'get',
                dataType: 'html',
                beforeSend: function () {
                    $(".overlay").show();
                },
                success: function (res) {
                    $("#meal_category_id").html(res);
                    $(".overlay").hide();
                }
            });
        });

    });
</script>
@endsection
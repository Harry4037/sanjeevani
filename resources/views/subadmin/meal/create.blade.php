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
                <form class="form-horizontal form-label-left" action="{{ route('subadmin.meal.add') }}" method="post" id="addMealForm" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Meal Name*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('meal_name') }}" type="text" class="form-control" name="meal_name" id="meal_name" placeholder="Meal Name">
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
                                @if($mealCategories)
                                @foreach($mealCategories as $mealCategory)
                                <option value="{{ $mealCategory->id }}">{{ $mealCategory->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Meal Type*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="meal_type" name="meal_type">
                                <option value="">Select option</option>
                                <option value="V">Veg</option>
                                <option value="N">Non Veg</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Meal Image*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="file" class="form-control" name="meal_image" id="meal_image">
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                            <a class="btn btn-default" href="{{ route('subadmin.meal.index') }}">Cancel</a>
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
//                resort_id: {
//                    required: true
//                },
                meal_name: {
                    required: true
                },
                meal_price: {
                    required: true
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

    });
</script>
@endsection
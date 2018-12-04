@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <h2>Update Meal</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <form class="form-horizontal form-label-left" action="{{ route('admin.meal.edit', $data->id) }}" method="post" id="editMealForm" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Resort</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="resort_id" name="resort_id">
                                <option value="">Select option</option>
                                @if($resorts)
                                @foreach($resorts as $resort)
                                <option value="{{ $resort->id }}"
                                        @if($resort->id == $data->resort_id)
                                        {{ "selected" }}
                                        @endif
                                        >{{ $resort->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Meal Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ $data->name }}" type="text" class="form-control" name="meal_name" id="meal_name" placeholder="Meal Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Meal Price</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ $data->price }}" type="text" class="form-control" name="meal_price" id="meal_price" placeholder="Meal Price">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Meal Category</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="meal_category_id" name="meal_category_id">
                                <option value="">Select option</option>
                                @if($mealCategories)
                                @foreach($mealCategories as $mealCategory)
                                <option value="{{ $mealCategory->id }}"
                                        @if($mealCategory->id == $data->meal_type_id)
                                        {{ "selected" }}
                                        @endif
                                        >{{ $mealCategory->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Meal Type</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="meal_type" name="meal_type">
                                <option value="">Select option</option>
                                <option value="V"
                                        @if($data->category == "V")
                                        {{ "selected" }}
                                        @endif
                                        >Veg</option>
                                <option value="N"
                                        @if($data->category == "N")
                                        {{ "selected" }}
                                        @endif
                                        >Non Veg</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Meal Image</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="file" class="form-control" name="meal_image" id="meal_image">
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                            <!--                            <button type="button" class="btn btn-primary">Cancel</button>-->
                            <button type="reset" class="btn btn-primary">Reset</button>
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
<script>
$(document).ready(function () {

   


});
</script>
@endsection
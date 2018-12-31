@extends('layouts.subadmin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <h2>Update Meal Package</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <form class="form-horizontal form-label-left" action="{{ route('subadmin.meal-package.edit', $data->id) }}" method="post" id="editMealpackageForm" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Meal Package Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ $data->name }}" type="text" class="form-control" name="name" id="name" placeholder="Meal Package Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Price</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ $data->price }}" type="text" class="form-control" name="price" id="price" placeholder="Meal Package Price">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Meal Type</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="category" name="category">
                                <option value="">Select option</option>
                                <option value="V" @if($data->category == "V"){{ "selected" }} @endif>Veg</option>
                                <option value="N" @if($data->category == "N"){{ "selected" }} @endif>Non Veg</option>
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Meal Package Image Preview</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <img src="{{ $data->image_name }}" class="img-rounded" width="300" height="150">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Meal Items</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div id="resort_meal_items">
                                <p style="padding: 5px;">
                                    @if($resortMeals)
                                    @foreach($resortMeals as $key => $item)
                                    <input class="flat" type="checkbox" name="meal_item[]" value="{{ $item->id }}"  
                                           @if(isset(old('meal_item')[$key]))
                                           @if(old('meal_item')[$key] == $item->id)
                                           {{ "checked" }}
                                           @endif
                                           @endif

                                           > {{ $item->name }}
                                           @endforeach
                                           @endif
                                <p>
                            </div>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                            <a class="btn btn-default" href="{{ route('subadmin.meal-package.index') }}">Cancle</a>
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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#editMealpackageForm").validate({
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
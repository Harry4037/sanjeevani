@extends('layouts.subadmin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <h2>Update Meal Category</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form class="form-horizontal form-label-left" action="{{ route('subadmin.meal-category.edit', $data->id) }}" method="post" id="editMealCategoryForm" >
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Category Name*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ $data->name }}" type="text" class="form-control" name="name" id="name" placeholder="Category Name">
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                            <a class="btn btn-default" href="{{ route('subadmin.meal-category.index') }}">Cancel</a>
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

        $("#editMealCategoryForm").validate({
            ignore: [],
            rules: {
                name: {
                    required: true
                }
            }
        });
    });
</script>
@endsection
@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <h2>Meal Order<small>({{$user->user_name}})</small></h2>
                <div class="pull-right">
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="panel panel-default">
                    <div class="panel-heading">Items Detail</div>
                    <div class="panel-body">
                        <form action="{{route('admin.users.user-order', $user->id)}}" method="post" id="orderItem">
                            @csrf
                            <div class="row">
                                <a href="javaScript:void(0);" class="btn btn-primary btn-xs pull-right" id="add_meal_item" > Add Meal Item </a>
                                <a href="javaScript:void(0);" class="btn btn-primary btn-xs pull-right" id="add_meal_package" > Add Meal Package </a>
                                <table id="list" class="table table-responsive  table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th>Meal Item</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <a href="{{route('admin.users.index')}}" class="btn btn-danger pull-right" >Cancel</a>
                            <input type="submit" class="btn btn-success pull-right" value="Submit">
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
    $(document).ready(function () {
        $(document).on('click', "#add_meal_item", function () {
            var meal_item_ids = [];
            $("select[name='meal_item_id[]'] :selected").each(function () {
                meal_item_ids.push($(this).val());
            });

            $.ajax({
                url: _baseUrl + "/admin/user/user-meal-item",
                type: "POST",
                data: {
                    user_id: "{{$user->id}}",
                    meal_item_ids: meal_item_ids,
                },
                beforeSend: function () {
                    $(".overlay").show();
                },
                success: function (response) {
                    $(".overlay").hide();
                    if (typeof response.status == "undefined") {
                        $("#list tbody").append(response);
                    } else {
                        showErrorMessage(response.msg);
                    }
                },
                error: function () {
                    alert();
                }
            });
        });

        $(document).on('click', "#add_meal_package", function () {
            var meal_package_ids = [];
            $("select[name='meal_package_id[]'] :selected").each(function () {
                meal_package_ids.push($(this).val());
            });
            $.ajax({
                url: _baseUrl + "/admin/user/user-meal-package",
                type: "POST",
                data: {
                    user_id: "{{$user->id}}",
                    meal_package_ids: meal_package_ids
                },
                beforeSend: function () {
                    $(".overlay").show();
                },
                success: function (response) {
                    $(".overlay").hide();
                    if (typeof response.status == "undefined") {
                        $("#list tbody").append(response);
                    } else {
                        showErrorMessage(response.msg);
                    }
                },
                error: function () {
                    alert();
                }
            });
        });

        $(document).on('change keyup', "input[name='meal_item_quantity[]']", function () {
            var quantity = this.value;
            if (quantity == '') {
                return true;
            } else if (quantity <= 0) {
                $(this).val(1);
            } else {
                return true;
            }
        });

        $(document).on('change keyup', "input[name='meal_package_quantity[]']", function () {
            var quantity = this.value;
            if (quantity == '') {
                return true;
            } else if (quantity <= 0) {
                $(this).val(1);
            } else {
                return true;
            }
        });

        $(document).on('click', ".delete_tr", function () {
            var _this = $(this);
            _this.parent("tr").remove();
        });
    });

    $(".select2").select2({
        width: "50%"
    });
</script>
@endsection


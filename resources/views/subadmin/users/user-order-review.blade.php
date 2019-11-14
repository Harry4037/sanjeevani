@extends('layouts.subadmin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <div style="display: none;" class="alert msg" role="alert">
                </div>
                <h2>Meal Order<small>({{$user->user_name}})</small></h2>
                <div class="pull-right">
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="panel panel-default">
                    <div class="panel-heading">Order Detail</div>
                    <div class="panel-body">
                        <form action="{{route('subadmin.users.user-order-create')}}" method="post" id="orderItem">
                            @csrf
                            <input type="hidden" name="user_id" value="{{$user->id}}">
                            <div class="row">
                                <table id="list" class="table table-responsive  table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th>Meal Item Name</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($mealPackageData)
                                        @foreach($mealPackageData as $mealPackage)
                                        <tr>
                                            <td>
                                                {{$mealPackage['name']}}
                                                <input type="hidden" name="meal_package_id[]" value="{{$mealPackage['id']}}">
                                            </td>
                                            <td>
                                                {{$mealPackage['qty']}}
                                                <input type="hidden" name="meal_package_qty[]" value="{{$mealPackage['qty']}}">
                                            </td>
                                            <td>
                                                {{$mealPackage['total_price']}}
                                                <input type="hidden" name="meal_package_price[]" value="{{$mealPackage['total_price']}}">
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                        @if($mealItemData)
                                        @foreach($mealItemData as $mealPackage)
                                        <tr>
                                            <td>
                                                {{$mealPackage['name']}}
                                                <input type="hidden" name="meal_item_id[]" value="{{$mealPackage['id']}}">
                                            </td>
                                            <td>
                                                {{$mealPackage['qty']}}
                                                <input type="hidden" name="meal_item_qty[]" value="{{$mealPackage['qty']}}">
                                            </td>
                                            <td>
                                                {{$mealPackage['total_price']}}
                                                <input type="hidden" name="meal_item_price[]" value="{{$mealPackage['total_price']}}">
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                        <tr>
                                            <td></td>
                                            <th>Total</th>
                                            <th>
                                                {{$total}}
                                                <input type="hidden" name="meal_total" value="{{$total}}">
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <a href="{{route('subadmin.users.user-order', $user->id)}}" class="btn btn-danger pull-right" >Cancel</a>
                            <input type="submit" class="btn btn-success pull-right" value="Submit Order">
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
@endsection


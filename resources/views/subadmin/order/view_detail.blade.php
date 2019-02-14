@extends('layouts.subadmin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <h2>Meal Order Detail</h2>
                <div class="pull-right">

                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="panel panel-default">
                    <div class="panel-heading">Order Detail</div>
                    <div class="panel-body">
                        <div class="row">
                            <label class="col-md-1 col-sm-1 col-xs-6">Invoice No.</label>
                            <div class="col-md-3 col-sm-3 col-xs-6">{{ isset($mealRequest->invoice_id) ? $mealRequest->invoice_id : "" }}</div>
                            <label class="col-md-1 col-sm-1 col-xs-6">User Name</label>
                            <div class="col-md-3 col-sm-3 col-xs-6">{{ isset($mealRequest->userDetail->user_name) ? $mealRequest->userDetail->user_name : "" }}</div>
                            <label class="col-md-1 col-sm-1 col-xs-6">Resort Name</label>
                            <div class="col-md-3 col-sm-3 col-xs-6">{{ isset($mealRequest->resortDetail->name) ? $mealRequest->resortDetail->name : "" }}</div>
                        </div>
                        <div class="row">
                            <label class="col-md-1 col-sm-1 col-xs-6">Room No.</label>
                            <div class="col-md-3 col-sm-3 col-xs-6">{{ isset($mealRequest->resort_room_no) ? $mealRequest->resort_room_no : "" }}</div>
                            <label class="col-md-1 col-sm-1 col-xs-6">Total Amount</label>
                            <div class="col-md-3 col-sm-3 col-xs-6">{{ isset($mealRequest->total_amount) ? $mealRequest->total_amount : "" }}</div>
                            <label class="col-md-1 col-sm-1 col-xs-6">Status</label>
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                @if($mealRequest->status == 1)
                                <span class='label label-success'>{{ "New" }}</span>
                                @elseif($mealRequest->status == 2)
                                <span class='label label-primary'>{{ "Accepted" }}</span>
                                @elseif($mealRequest->status == 3)
                                <span class='label label-info'>{{ "Approval Needed" }}</span>
                                @elseif($mealRequest->status == 4)
                                <span class='label label-success'>{{ "Completed" }}</span>
                                @elseif($mealRequest->status == 5)
                                <span class='label label-danger'>{{ "Not Resolved" }}</span>
                                <br>
                                <label>Staff comment: </label> {{ $mealRequest->staff_comment }}
                                @endif
                            </div>
                        </div>
                        @if($mealRequest->status > 1)
                        <div class="row">
                            <label class="col-md-1 col-sm-1 col-xs-6">Accepted By</label>
                            <div class="col-md-3 col-sm-3 col-xs-6">{{ isset($mealRequest->acceptedBy->user_name) ? $mealRequest->acceptedBy->user_name : "" }}</div>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Items Detail</div>
                    <div class="panel-body">
                        <div class="row">
                            <table class="table table-responsive  table-bordered">
                                <thead>
                                    <tr>
                                        <th>Meal Item Name</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($mealRequest->orderItems)
                                    @foreach($mealRequest->orderItems as $item)
                                    <tr>
                                        <td>{{ $item->meal_item_name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->price }}</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

                <form class="form-horizontal form-label-left" action="{{ route('subadmin.order.view', $mealRequest->id) }}" method="post" id="mealOrderForm">
                    @csrf
                   
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Status</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="seleted_status" id="seleted_status">
                                <option value="">Select Option</option>
                                <option value="1" @if($mealRequest->status == 1){{ "selected" }}@endif>New</option>
                                <!--<option value="2">Accepted/In-Progress</option>-->
                                <option value="3" @if($mealRequest->status == 3){{ "selected" }}@endif>Mark as complete/Under Approval</option>
                                <option value="4" @if($mealRequest->status == 4){{ "selected" }}@endif>Approved/Completed</option>
                                <option value="5" @if($mealRequest->status == 5){{ "selected" }}@endif>Rejected/Not Resolved</option>
                            </select>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                            <a class="btn btn-default" href="{{ route('subadmin.order.index') }}">Cancel</a>
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
        $("#mealOrderForm").validate({
            ignore: [],
            rules: {
                seleted_status: {
                    required: true
                },
            }
        });
    });
</script>
@endsection


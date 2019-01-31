@extends('layouts.subadmin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <div style="display: none;" class="alert msg" role="alert">
                </div>
                <h2>Order & Request Detail</h2>
                <div class="pull-right">

                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form class="form-horizontal form-label-left" action="{{ route('subadmin.order-request.view', $serviceRequest->id) }}" method="post" id="addBookingForm">
                    @csrf

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Service Type</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input readonly="true" type="text" class="form-control"  name="service_type" id="service_type" value="@if(isset($serviceRequest->serviceDetail->serviceType->name)){{ $serviceRequest->serviceDetail->serviceType->name }}@endif">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Service Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input readonly="true" type="text" class="form-control"  name="service_name" id="service_name" value="@if(isset($serviceRequest->serviceDetail->name)){{ $serviceRequest->serviceDetail->name }}@endif">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input readonly="true" type="text" class="form-control"  name="customer_name" id="customer_name" value="@if(isset($serviceRequest->userDetail->user_name)){{ $serviceRequest->userDetail->user_name }}@endif">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Room No.</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input readonly="true" type="text" class="form-control"  name="room_no" id="room_no" value="@if(isset($serviceRequest->resort_room_no)){{ $serviceRequest->resort_room_no }}@endif">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input readonly="true" type="text" class="form-control"  name="request_status" id="request_status" value="@if(isset($serviceRequest->requestStatus->status)){{ $serviceRequest->requestStatus->status }}@endif">
                        </div>
                    </div>
                    @if($serviceRequest->requestStatus->id > 1)
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Accepted by</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input readonly="true" type="text" class="form-control"  name="accepted_by" id="accepted_by" value="@if(isset($serviceRequest->acceptedBy->user_name)){{ $serviceRequest->acceptedBy->user_name }}@endif">
                        </div>
                    </div>
                    @endif
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Status</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="seleted_status" id="seleted_status">
                                <option value="">Select Option</option>
                                <option value="1">New</option>
                                <option value="2">Accepted/In-Progress</option>
                                <option value="3">Mark as complete/Under Approval</option>
                                <option value="4">Approved/Completed</option>
                                <option value="5">Rejected/Not Resolved</option>
                            </select>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                            <a class="btn btn-default" href="{{ route('subadmin.order-request.index') }}">Cancel</a>
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
        $("#addBookingForm").validate({
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

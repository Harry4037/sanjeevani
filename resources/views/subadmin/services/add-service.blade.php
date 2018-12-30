@extends('layouts.subadmin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <h2>Add Service</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>

                <form class="form-horizontal form-label-left" action="{{ route('subadmin.service.add') }}" method="post" id="addServiceForm" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Service Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input value="{{ old('service_name') }}" type="text" class="form-control" name="service_name" id="service_name" placeholder="Service Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Service Type</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="service_type" id="service_type">
                                <option value="">Choose option</option>
                                @if($serviceType)
                                @foreach($serviceType as $serviceT)
                                <option value="{{ $serviceT->id }}" 
                                        @if(old('service_type') == $serviceT->id)
                                        {{ "selected" }}
                                        @endif
                                        >{{ $serviceT->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Service Icon</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="file" class="form-control" name="service_icon" id="service_icon" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Questions</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <p style="padding: 5px;">
                                @if($question)
                                @foreach($question as $key => $ques)
                                <input class="flat" type="checkbox" name="service_question[]" value="{{ $ques->id }}"  
                                       @if(isset(old('service_question')[$key]))
                                       @if(old('service_question')[$key] == $ques->id)
                                       {{ "checked" }}
                                       @endif
                                       @endif

                                       > {{ $ques->name }}
                                       <br>
                                @endforeach
                                @endif
                            <p>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-4">
                            <a class="btn btn-default" href="{{ route('subadmin.service.index') }}">Cancel</a>
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
        $("#addServiceForm").validate({
            rules: {
                service_name: {
                    required: true
                },
                service_icon: {
                    required: true,
                    accept: "image/*",
                },
                service_type: {
                    required: true
                },
                resort_id: {
                    required: true
                }
            },
            messages: {
                service_icon: {
                    accept: "Not valid image type"
                }
            }
        });
    });
</script>
@endsection
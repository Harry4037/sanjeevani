@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <h2>Edit Service</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>

                <form class="form-horizontal form-label-left" action="{{ route('admin.service.edit', $data->id) }}" method="post" id="editServiceForm" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Service Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input value="{{ $data->name }}" type="text" class="form-control" name="service_name" id="service_name" placeholder="Service Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Service Icon</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="file" class="form-control" name="service_icon" id="service_icon" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Service Type</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="service_type" id="service_type">
                                <option value="">Choose option</option>
                                @if($sTypes)
                                @foreach($sTypes as $sType)
                                <option value="{{ $sType->id }}"
                                        @if($sType->id == $data->type_id)
                                        {{ "selected" }}
                                        @endif
                                        >{{ $sType->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Resort</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="resort_id" id="resort_id">
                                <option value="">Choose option</option>
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Questions</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <p style="padding: 5px;">
                                @if($questions)
                                @foreach($questions as $question)
                                <input class="flat" type="checkbox" name="service_question[]" value="{{ $question->id }}" @if(in_array($question->id, $qSArray)) {{ "checked" }} @endif > {{ $question->name }}
                                <br>
                                @endforeach
                                @endif
                            <p>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                            <!--                            <button type="button" class="btn btn-primary">Cancel</button>-->
                            <button type="reset" class="btn btn-primary">Reset</button>
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
        $("#editServiceForm").validate({
            rules: {
                service_name: {
                    required: true
                },
                service_type: {
                    required: true
                },
                resort_id: {
                    required: true
                }
            }
        });
    });
</script>
@endsection
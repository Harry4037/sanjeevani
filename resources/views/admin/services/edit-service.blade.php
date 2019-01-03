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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Service Icon Preview</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <img src="{{ $data->icon }}" width="100" height="60">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Service Type</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="service_type" id="service_type">
                                <option value="">Choose                                     option</option>
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
                    <div id="service_question">
                        @if($serviceQuestions)
                        @foreach($serviceQuestions as $key => $serviceQuestion)
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Question {{ $key+1 }} </label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <input type="text" value="{{ $serviceQuestion->question }}" class="form-control" name="question[]"  placeholder="question">
                            </div>
                            <i style='cursor:pointer' class='fa fa-times delete_question' id="{{ $serviceQuestion->id }}"></i>
                        </div>
                        @endforeach
                        @endif
                    </div>
                    @if(count($serviceQuestions) < 4)
                    <div class="form-group">
                        <div class="col-md-2 col-sm-2 col-xs-12 col-md-offset-8">
                            <input type="hidden" id="question_count" value="{{ count($serviceQuestions) }}">
                            <button type="button" class="btn btn-primary" id="add_service_question">Add Members</button>
                        </div>
                    </div>
                    @endif
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-4">
                            <a class="btn btn-default" href="{{ route('admin.service.index') }}">Cancel</a>
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

        $(document).on("click", ".delete_question", function () {
            var _this = $(this);
            var record_id = this.id;
            var question_count = $("#question_count").val();
            $.ajax({
                url: _baseUrl + '/admin/services/delete-question',
                type: 'post',
                data: {record_id: record_id},
                dataType: 'json',
                success: function (res) {
                    if (res.status)
                    {
                        question_count--;
                        $("#question_count").val(question_count);
                        _this.parent("div").remove();
                    } else {
                        alert("Something went be wrong");
                    }
                }
            });
        });
        $(document).on("click", ".delete_this_div", function () {
            var question_count = $("#question_count").val();
            question_count--;
            $("#question_count").val(question_count);
            $(this).parent("div").remove();
        });
        $(document).on("click", "#add_service_question", function () {
            var question_count = $("#question_count").val();
            if (question_count < 4) {
                question_count++;
                var member_html = "<div class='form-group'>"
                        + "<label class='control-label col-md-3 col-sm-3 col-xs-12'>Question " + question_count + "</label>"
                        + "<div class='col-md-6 col-sm-6 col-xs-6' id='service_question'>"
                        + "<input type='text' class='form-control' name='question[]'  placeholder='question'>"
                        + "</div>"
                        + "<i style='cursor:pointer' class='fa fa-times delete_this_div'></i></div>";
                $("#service_question").append(member_html);

                $("#question_count").val(question_count);
            } else {
                alert("Only four questions allowed.");
            }
        });

        $("#editServiceForm").validate({
            rules: {
                service_name: {
                    required: true
                },
                service_type: {
                    required: true
                },
                service_icon: {
                    accept: "image/*",
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
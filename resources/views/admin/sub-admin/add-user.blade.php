@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <h2>Add Subadmin </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <form class="form-horizontal form-label-left" action="{{ route('admin.subadmin.add') }}" method="post" id="addSubadminForm">
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Name*</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input value="{{ old('name') }}" type="text" class="form-control" placeholder="Name" name="name" id="name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Email*</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input value="{{ old('email') }}" type="text" class="form-control" placeholder="Email" name="email" id="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Password*</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input value="{{ old('password') }}" type="password" class="form-control" placeholder="Password" name="password" id="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Confirm Password*</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input value="{{ old('confirm_password') }}" type="password" class="form-control" placeholder="Confirm Password" name="confirm_password" id="confirm_password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Resort Name*</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="resort_id" id="resort_id">
                                <option value="">Choose option</option>
                                @if($resorts)
                                @foreach($resorts as $resort)
                                <option value="{{ $resort->id }}"
                                        @if(old('staff_email') == $resort->id)
                                        {{ "slected" }}
                                        @endif
                                        >{{ $resort->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Menu's</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <p style="padding: 5px;">
                                @if($menus)
                                @foreach($menus as $menu)
                            <div class="col-md-6 col-sm-6 col-xs-6" style="padding-bottom: 4px;">
                                <input class="flat" type="checkbox" name="menu_ids[]" value="{{ $menu->id }}"><label>{{ $menu->display_name }}</label>
                            </div>
                            @endforeach
                            @endif
                            </p>
                        </div>
                    </div>
                    <div id="menuIdError" class="error col-md-offset-4"></div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-4">
                            <a  class="btn btn-default" href="{{ route('admin.subadmin.index') }}">Cancel</a>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#addSubadminForm").validate({
            rules: {
                name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true
                },
                confirm_password: {
                    required: true,
                    equalTo: "#password"
                },
                resort_id: {
                    required: true
                },
                "menu_ids[]": {
                    required: function () {
                        return $("[name='menu_ids[]']:checked").length == 0;
                    }
                }
            },
            messages: {
                "menu_ids[]": {
                    required: 'Please add some rights from menus.'
                }
            },
            errorPlacement: function (error, el) {
                if ($(el).attr('type') == 'checkbox') {
                    console.log(error);
                    error.appendTo("#menuIdError");
                } else {
                    error.insertAfter(el);
                }
            }
        });

        if ($("input.flat")[0]) {
            $(document).ready(function () {
                $('input.flat').iCheck({
                    checkboxClass: 'icheckbox_flat-green',
                    radioClass: 'iradio_flat-green'
                });
            });
        }
    });
</script>

@endsection
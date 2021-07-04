@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <h2>{{$user->first_name}}'s Payment</h2>
                <div class="pull-right">
                    <a class="btn btn-info" href="{{ route('admin.users.index') }}">Back</a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <form method="post" action="{{route('admin.users.payments', $user->id)}}" id="paymentForm">
                            @csrf
                            <input type="hidden" name="user_id" value="{{$user->id}}">
                            <div class="form-group">
                                <label for="">Select Resort</label>
                                <select class="form-control" name="resort_id" id="resort_id">
                                    <option value="">--Chose option--</option>
                                    @if($userResort)
                                    @foreach($userResort as $k => $val)
                                    <option value="{{$k}}">{{$val}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label for=""></label>
                                <button type="submit" class="btn btn-success pull-right">Submit</button>
                            </div>
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
        $("#paymentForm").validate({
            rules: {
                resort_id: {
                    required: true
                },

            }});

    });
</script>
@endsection
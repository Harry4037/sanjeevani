@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <div style="display: none;" class="alert msg" role="alert">
                </div>
                <h2>Resorts Nearby<small>({{ $resort->name }})</small></h2>
                <script>
                    var resort_id = {{ $resort->id }};
                </script>
                    <div class="pull-right">
                        <a class="btn btn-success" href="{{ route('admin.resort.add') }}">Add Nearby</a>
                    </div>
                    <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="list" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Sr.No.</th>
                            <th>Nearby Name</th>
                            <th>Distance</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

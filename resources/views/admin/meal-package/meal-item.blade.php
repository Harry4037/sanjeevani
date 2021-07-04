<link href="{{ asset("vendors/iCheck/skins/flat/green.css") }}" rel="stylesheet">
@if($mealCategories)
@foreach($mealCategories as $k => $mealCategory)
<div class="panel-group">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" href="#{{ 'collapse'.$k }}">{{ $mealCategory->name }}</a>
            </h4>
        </div>
        <div id="{{ 'collapse'.$k }}" class="<?php
        if ($k == 0) {
            echo 'panel-collapse collapse in';
        } else {
            echo 'panel-collapse collapse';
        }
        ?>">
            <div class="panel-body">
                <p style="padding: 5px;">
                    @foreach($mealCategory->menuItems as $key => $item)
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input class="flat" type="checkbox" name="meal_item[]" value="{{ $item->id }}"  
                           @if(isset(old('meal_item')[$key]))
                           @if(old('meal_item')[$key] == $item->id)
                           {{ "checked" }}
                           @endif
                           @endif

                           > {{ $item->name }}
                </div>

                @endforeach
                <p>
            </div>
        </div>
    </div>
</div>
@endforeach
@endif
<script src="{{ asset("vendors/iCheck/icheck.min.js") }}"></script>
<script>
$(document).ready(function () {
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


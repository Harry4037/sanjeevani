
@if($mealCategories)
@foreach($mealCategories as $k => $mealCategory)
<div class="panel-group">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" href="#{{ 'collapse'.$k }}">{{ $mealCategory->name }}</a>
            </h4>
        </div>
        <div id="{{ 'collapse'.$k }}" class="<?php if($k==0){ echo 'panel-collapse collapse in'; }else{ echo 'panel-collapse collapse'; } ?>">
            <div class="panel-body">
                <p style="padding: 5px;">
                    @foreach($mealCategory->menuItems as $key => $item)
                    <input class="flat" type="checkbox" name="meal_item[]" value="{{ $item->id }}"  
                           @if(isset(old('meal_item')[$key]))
                           @if(old('meal_item')[$key] == $item->id)
                           {{ "checked" }}
                           @endif
                           @endif

                           > {{ $item->name }}

                           @endforeach
                <p>
            </div>
        </div>
    </div>
</div>
@endforeach
@endif




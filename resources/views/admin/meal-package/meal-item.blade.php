<p style="padding: 5px;">
    @if($mealItems)
    @foreach($mealItems as $key => $item)
    <input class="flat" type="checkbox" name="meal_item[]" value="{{ $item->id }}"  
           @if(isset(old('meal_item')[$key]))
           @if(old('meal_item')[$key] == $item->id)
           {{ "checked" }}
           @endif
           @endif

           > {{ $item->name }}
           @endforeach
           @endif
<p>
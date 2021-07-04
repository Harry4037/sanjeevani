<tr>
    <td>
        <select class="form-control select2" name="meal_item_id[]">
            @if($mealItems)
            @foreach($mealItems as $mealItem)
            <option value="{{$mealItem->id}}">{{$mealItem->name.' (Rs. '.$mealItem->price.')'}}</option>
            @endforeach
            @endif
        </select>
    </td>
    <td style="width: 7%;"><input class="form-control" type="number" value="1" name="meal_item_quantity[]"></td>
    <td style="width: 1px; cursor: pointer;" class="delete_tr"><i title="Delete" class="fa fa-times" style="color: red;"></i></td>
</tr>

<script>
    $(".select2").select2({
        width: "50%"
    });
</script>

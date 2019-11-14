<tr>
    <td>
        <select class="form-control select2" name="meal_package_id[]">
            @if($mealPackages)
            @foreach($mealPackages as $mealPackage)
            <option value="{{$mealPackage->id}}">{{$mealPackage->name.' (Rs. '.$mealPackage->price.')'}}</option>
            @endforeach
            @endif
        </select>
    </td>
    <td style="width: 7%;"><input class="form-control" type="number" value="1" name="meal_package_quantity[]"></td>
</tr>

<script>
    $(".select2").select2({
        width: "50%"
    });
</script>

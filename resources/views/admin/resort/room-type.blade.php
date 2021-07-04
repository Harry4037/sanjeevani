
<option value="">Choose option</option>
@if(count($roomTypes) > 0)
@foreach($roomTypes as $roomType)
<option value="{{ $roomType->id }}">{{ $roomType->name }}</option>
@endforeach
@else
<option value="">--No Room Type Avalaible--</option>
@endif
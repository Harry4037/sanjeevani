<option value="">Choose option</option>
@if($resortRooms)
@foreach($resortRooms as $resortRoom)
<option value="{{ $resortRoom->id }}">{{ $resortRoom->room_no }}</option>
@endforeach
@endif
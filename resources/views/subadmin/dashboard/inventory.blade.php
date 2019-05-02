<div class="ln_solid"></div>
<div class="panel-body text-center">
    @if(count($rooms) > 0)
    @foreach($rooms as $room)
    <button type="button" 
            class="@if(in_array($room->id, $roomIds)){{ 'btn btn-round btn-danger' }}@else{{ 'btn btn-round btn-success' }}@endif">
        {{ $room->room_no }}</button>
    @endforeach
    @else
    {{ "No Rooms Found." }}
    @endif
</div>


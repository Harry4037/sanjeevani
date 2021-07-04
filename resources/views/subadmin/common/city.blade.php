<option value="">Choose option</option>
@if($cities)
@foreach($cities as $citiy)
<option value="{{ $citiy->id }}">{{ $citiy->city }}</option>
@endforeach
@endif
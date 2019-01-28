<option value="">Choose option</option>
@if($healthcares)
@foreach($healthcares as $healthcare)
<option value="{{ $healthcare->id }}">{{ $healthcare->name }}</option>
@endforeach
@endif
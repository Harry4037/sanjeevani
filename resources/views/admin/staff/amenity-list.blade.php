<p style="padding: 5px;">
    @if($amenities)
    @foreach($amenities as $amenity)
    <input class="flat" type="checkbox" name="amenity_ids[]" value="{{ $amenity->id }}">{{ $amenity->name }}
    @endforeach
    @endif
<p>
<option value="">-- Select type --</option>
@foreach($dept as $d)
    <option value="{{ $d->id }}">{{ $d->name }}</option>
@endforeach
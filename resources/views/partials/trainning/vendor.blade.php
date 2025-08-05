@if($vendors)
<option value="">-- Select type --</option>
@foreach($vendors as $vendor)
    <option value="{{ $vendor->id }}">{{ $vendor->vendor_name }}</option>
@endforeach
@else
    <option value="">Data Not Found</option>
@endif
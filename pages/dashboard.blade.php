@extends('_main_layout')

@section('content')
<div class="col-lg-12">
    <h1>Your are Logined!</h1>
    <input type="text" name="ip" id="ip" />
    <div class="barcode">
        <?= '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG("1803010000000230", "C128C") . '" alt="barcode"   />'?>
            <div class="caption post-content">
                <p>1803010000000230</p> 
            </div>
    </div>
</div>
@endsection
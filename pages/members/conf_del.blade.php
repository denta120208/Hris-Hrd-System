@extends('_main_layout')

@section('content')
<div class="col-lg-12">
    <h1>Member {!! $member->first_name." ".$member->last_name !!}</h1>
    <div class="col-md-12">&nbsp;</div>
    <div class="col-md-6">
        {!! Form::open(['method' => 'delete', 'route' => ['members.destroy', $member->id] ]) !!}
        <input type="hidden" name="ip" id="ip" />
        <div class="form-group">
            <label for="name">Name</label>
            <input class="form-control" type="text" name="name" id="name" value="{{ $member->first_name." ".$member->last_name }}" disabled="disabled" />
        </div>
        <div class="form-group">
            <label for="hp_tlp">No Hp/Tlp</label>
            <input class="form-control" type="text" name="hp_tlp" id="hp_tlp" value="{{ $member->hp_tlp }}" disabled="disabled" />
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input class="form-control" type="text" name="email" id="email" value="{{ $member->email }}" disabled="disabled" />
        </div>
        <div class="form-group">
            <label for="card_no">Metland Card No</label>
            <input class="form-control" type="text" name="card_no" id="card_no" value="{{ $member->card_no }}" disabled="disabled" />
        </div>
        <input type="submit" value="Delete" class="btn btn-danger" />
        <a class="btn btn-success" href="{{ route('members.index') }}">Back</a>
        {!! Form::close() !!}
    </div>
</div>
@endsection
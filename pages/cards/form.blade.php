@extends('_main_layout')

@section('content')

<div class="col-lg-12">
    <h1>{!! $card->exists ? 'Edit Card Type' : 'Create Card Type' !!}</h1>
    &nbsp;
    {!! Form::open([
        'method' => $card->exists ? 'put' : 'post',
        'route' => $card->exists ? ['cards.update', $card->id] : ['cards.store'],
    ]) !!}
    <input type="hidden" name="ip" id="ip" />
    <div class="form-group">
        <label for="name">Name</label>
        <input class="form-control" type="text" name="name" id="name" value="{{ $card->name }}" />
    </div>
    @if($card->exists)
    <div class="form-group">
        <label for="status">Status</label>
        <select name="status" id="status" class="form-control">
            <option value="1">Activate</option>
            <option value="0">Deactivate</option>
        </select>
    </div>
    @endif
    <div class="form-group col-lg-12">
        <input type="submit" value="Save" class="btn btn-primary" />
        <a class="btn btn-danger" href="{{ route('cards.index') }}">Back</a>
    </div>
    {!! Form::close() !!}
</div>
@endsection
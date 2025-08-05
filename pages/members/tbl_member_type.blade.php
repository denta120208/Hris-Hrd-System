<div class="col-md-6 col-md-offset-3">
    @if(!empty($mtype))
    {!! Form::open(['method' => 'PUT', 'url' => ['members.type_store', $mtype->id]]) !!}
    <div class="form-group">
        {!! Form::label('name', 'Name') !!}
        {!! Form::text('name', $mtype->name, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('name', 'Name') !!}
        {!! Form::text('name', $mtype->name, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('name', 'Name') !!}
        {!! Form::text('name', $mtype->name, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('name', 'Name') !!}
        {!! Form::text('name', $mtype->name, ['class' => 'form-control']) !!}
    </div>
    <a class="btn btn-danger" href="{{ route('members.index') }}">Back</a>
    <input type="submit" name="btn_save" value="Save" class="btn btn-primary"  />
    {!! Form::close() !!}
    @else
    <h2>Data Not Found!!</h2>
    @endif
</div>
@extends('_main_layout')

@section('content')
<div class="container">
    <div class="row">
        <h1>Edit Attachment</h1>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <form action="{{ route('attachment.update', $attachment->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="eattach_filename">File Name</label>
                    <input type="text" class="form-control" id="eattach_filename" name="eattach_filename" value="{{ $attachment->eattach_filename }}" required />
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ url()->previous() }}" class="btn btn-default">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection

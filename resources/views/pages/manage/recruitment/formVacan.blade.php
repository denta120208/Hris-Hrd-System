@extends('_main_layout')

@section('content')
<script src="{{ URL::asset('ckeditor/ckeditor.js') }}"></script>
<script>
$(document).ready(function() {
    var konten = document.getElementById("description");
    CKEDITOR.replace(konten, {
        language: 'en-gb'
    });
    CKEDITOR.config.allowedContent = true;
});
</script>
<div class="container">
    <h2>Vacancy Form</h2>
<div style="margin-bottom: 20px;"></div>
<div class="row">
    <div style="margin-bottom: 60px;"></div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

{!! Form::model('JobVacancy', [
    'method' => $jvs->exists ? 'put' : 'post',
    'route' => $jvs->exists ? ['hrd.vacan.update', $jvs->id] : ['hrd.vacan.store'],
]) !!}
    <div class="modal-body">
        <input type="hidden" name="id" id="id" />
        <div class="form-group">
            <label for="name">Job Title</label>
            <input class="form-control" type="text" name="name" id="name" value="{{ $jvs->name }}" />
        </div>
        <div class="form-group">
            <?php
            $job_title_code = \App\Models\Master\JobMaster::lists('job_title','id')->prepend('Job Level', '0');
            ?>
            {!! Form::label('job_title_code', 'Job Level') !!}
            {!! Form::select('job_title_code', $job_title_code, $jvs->job_title_code, ['class' => 'form-control job_title_code', 'id' => 'job_title_code']) !!}
        </div>
        <div class="form-group">
            <?php
            $dept_id = \App\Models\Employee\JobCategory::lists('name','id')->prepend('Divisi', '0');
            ?>
            {!! Form::label('dept_id', 'Divisi') !!}
            {!! Form::select('dept_id', $dept_id, $jvs->dept_id, ['class' => 'form-control dept_id', 'id' => 'dept_id']) !!}
        </div>
        <div class="form-group">
            <?php
            $loc_id = \App\Models\Master\Location::lists('name','id')->prepend('Location', '0');
            ?>
            {!! Form::label('location_id', 'Location') !!}
            {!! Form::select('location_id', $loc_id, $jvs->location_id, ['class' => 'form-control location_id', 'id' => 'location_id']) !!}
        </div>
        <div class="form-group">
            <label for="no_of_positions">No of Position</label>
            <input class="form-control" type="number" name="no_of_positions" id="no_of_positions" value="{{ $jvs->no_of_positions }}" />
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" rows="10" cols="50">{{ $jvs->description }}</textarea>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
    </div>
</div>
</div>
@endsection
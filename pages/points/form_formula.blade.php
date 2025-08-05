@extends('_main_layout')

@section('content')
<script type="text/javascript">
$(function () {
    $('#point_frdate').datetimepicker({
        format: 'YYYY-MM-DD H:m'
    });
    $('#point_todate').datetimepicker({
        useCurrent: false,
        format: 'YYYY-MM-DD H:m'
    });
    $("#point_frdate").on("dp.change", function (e) {
        $('#point_todate').data("DateTimePicker").minDate(e.date);
    });
    $("#point_todate").on("dp.change", function (e) {
        $('#point_frdate').data("DateTimePicker").maxDate(e.date);
    });
});
</script>
<div class="col-lg-6 col-lg-offset-3">
    <h2>{!! $formula->exists ? 'Edit Point Formula' : 'Add Point Formula' !!}</h2>
    {!! Form::model('point_formula', [
        'method' => $formula->exists ? 'put' : 'post',
        'route' => $formula->exists ? ['point_formula.update', $formula->id] : ['point_formula.store'],
    ]) !!}
    <input type="hidden" name="ip" id="ip" />
    <div class="form-group">
        {!! Form::label('desc', 'Description') !!}
        {!! Form::text('desc', $formula->point_desc, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('point_type', 'Point Type') !!}
        {!! Form::select('point_type', array('' => '-=Pilih=-', '1' => 'Redeem', '2' => 'Lucky Draw'), $formula->point_type, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('point_amount', 'Amount') !!}
        {!! Form::text('point_amount', $formula->point_amount, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('point_value', 'Points') !!}
        {!! Form::text('point_value', $formula->point_value, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        <?php
        $bank_id = App\Models\Bank::lists('name', 'id')->prepend('-=Pilih=-', '');
        ?>
        {!! Form::label('point_bank', 'Bank') !!}
        {!! Form::select('point_bank', $bank_id, $formula->point_bank, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        <?php
        $tenant_id = App\Tenant::lists('name', 'id')->prepend('-=Pilih=-', '');
        ?>
        {!! Form::label('point_tenant', 'Tenant/Service') !!}
        {!! Form::select('point_tenant', $tenant_id, $formula->point_tenant, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('point_amount_max', 'Point Amount Max') !!}
        {!! Form::text('point_amount_max', $formula->point_amount_max, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('date_point', 'Valid Point Date') !!}
        <div class="input-group">
            {!! Form::text('point_frdate', $formula->point_frdate, ['class' => 'form-control', 'id' => 'point_frdate']) !!}
            <span class="input-group-addon">-</span>
            {!! Form::text('point_todate', $formula->point_todate, ['class' => 'form-control', 'id' => 'point_todate']) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('days', 'Days') !!}
        <div class="checkbox">
            <label>
                {!! Form::checkbox('point_monday', $value = 1, $formula->point_monday) !!}
                Monday
            </label>
            <label>
                {!! Form::checkbox('point_tuesday', $value = 1, $formula->point_tuesday) !!}
                Tuesday
            </label>
            <label>
                {!! Form::checkbox('point_wednesday', $value = 1, $formula->point_wednesday) !!}
                Wednesday
            </label>
            <label>
                {!! Form::checkbox('point_thursday', $value = 1, $formula->point_thursday) !!}
                Thursday
            </label>
            <label>
                {!! Form::checkbox('point_friday', $value = 1, $formula->point_friday) !!}
                Friday
            </label>
            <label>
                {!! Form::checkbox('point_saturday', $value = 1, $formula->point_saturday) !!}
                Saturday
            </label>
            <label>
                {!! Form::checkbox('point_sunday', $value = 1, $formula->point_sunday) !!}
                Sunday
            </label>
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('point_active', 'Active') !!}
        <div class="checkbox">
            <label>
                {!! Form::checkbox('point_active', $value = 1, $formula->point_active) !!}
                Activate Point Formula
            </label>
        </div>
    </div>
    <div class='col-sm-4 pull-right'>
        <input type="submit" value="Save" class="btn btn-primary" />
        <a class="btn btn-danger" href="{{ route('point_formula.index') }}">Back</a>
    </div>
    {!! Form::close() !!}
</div>
@endsection
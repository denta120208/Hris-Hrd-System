<script>
$(document).ready(function(){
    $('#personalDtlSave').hide();
    $('#personalDtlCancel').hide();
    $('#personalDtl').click(function(){
        $('#personalForm input[type="text"]').prop("readonly", false);
        $('#emp_gender').prop("disabled", false);
        $('#nation_code').prop("disabled", false);
        $('#personalDtl').hide();
        $('#personalDtlSave').show();
        $('#personalDtlCancel').show();
    });
    $('#personalDtlCancel').click(function(){
        $('#personalForm input[type="text"]').prop("readonly", true);
        $('#emp_gender').prop("disabled", true);
        $('#nation_code').prop("disabled", true);
        $('#personalDtl').show();
        $('#personalDtlSave').hide();
        $('#personalDtlCancel').hide();
    });
    $('#personalDtlSave').click(function (){
        $('form#personalForm').submit();
    });
    // $('#emp_dri_lice_exp_date').datepicker({
    //     format: 'yyyy-mm-dd',
    // });
    // $('#emp_birthday').datepicker({
    //     format: 'yyyy-mm-dd',
    // });
});
</script>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<form id="personalForm" action="{{ route('setpersonal') }}" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="emp_number" value="{{ $emp->emp_number }}" />
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="form-group">
            <label for="name">Firstname</label>
            <input class="form-control" type="text" name="emp_firstname" id="emp_firstname" value="{{ $emp->emp_firstname }}" readonly="readonly" />
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="form-group">
            <label for="emp_middle_name">Middlename</label>
            <input class="form-control" type="text" name="emp_middle_name" id="emp_middle_name" value="{{ $emp->emp_middle_name }}" readonly="readonly" />
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="form-group">
            <label for="emp_lastname">Lastname</label>
            <input class="form-control" type="text" name="emp_lastname" id="emp_lastname" value="{{ $emp->emp_lastname }}" readonly="readonly" />
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="employee_id">Employee Ids</label>
            <input class="form-control" type="text" name="employee_id" id="employee_id" value="{{ $emp->employee_id }}" disabled="disabled" />
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="emp_ktp">KTP</label>
            <input class="form-control" type="text" name="emp_ktp" id="emp_ktp" value="{{ $emp->emp_ktp }}" readonly="readonly" />
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <?php
            $emp_gender = array('-=Pilih=-','Male','Female');
            ?>
            {!! Form::label('emp_gender', 'Gender') !!}
            {!! Form::select('emp_gender', $emp_gender, $emp->emp_gender, ['class' => 'form-control', 'id' => 'emp_gender', 'disabled' => 'disabled']) !!}
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <?php $nationality = \App\Models\Master\Nationality::lists('name', 'id')->prepend('-=Pilih=-', '0');?>
            {!! Form::label('nation_code', 'Nationality') !!}
            {!! Form::select('nation_code', $nationality, $emp->nation_code, ['class' => 'form-control', 'id' => 'nation_code', 'disabled' => 'disabled']) !!}
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="emp_dri_lice_num">Driver's License Number</label>
            <input class="form-control" type="text" name="emp_dri_lice_num" id="emp_dri_lice_num" value="{{ $emp->emp_dri_lice_num }}" readonly="readonly" />
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="emp_dri_lice_exp_date">License Expiry Date</label>
            <input class="form-control" type="text" name="emp_dri_lice_exp_date" id="emp_dri_lice_exp_date" value="{{ if($emp->emp_dri_lice_exp_date != '01-01-1970' && $emp->emp_dri_lice_exp_date != '01-01-1900') {$emp->emp_dri_lice_exp_date} }}" readonly="readonly" />
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="emp_marital_status">Marital Status</label>
            <input class="form-control" type="text" name="emp_marital_status" id="emp_marital_status" value="{{ $emp->emp_marital_status }}" readonly="readonly" />
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="emp_birthday">Date of Birth</label>
            <input class="form-control" type="text" name="emp_birthday" id="emp_birthday" value="{{ $emp->emp_birthday }}" readonly="readonly" />
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="form-group">
            <label for="bpjs_ks">BPJS Kes</label>
            <input class="form-control" type="text" name="bpjs_ks" id="bpjs_ks" value="{{ $emp->bpjs_ks }}" readonly="readonly" />
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="form-group">
            <label for="bpjs_tk">BPJS TK</label>
            <input class="form-control" type="text" name="bpjs_tk" id="bpjs_tk" value="{{ $emp->bpjs_tk }}" readonly="readonly" />
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="form-group">
            <label for="npwp">No NPWP</label>
            <input class="form-control" type="text" name="npwp" id="npwp" value="{{ $emp->npwp }}" readonly="readonly" />
        </div>
    </div>
</form>
</div>
<button class="btn btn-success" id="personalDtl">Edit</button>
<button class="btn btn-primary" id="personalDtlSave">Save</button>
<button class="btn btn-danger" id="personalDtlCancel">Cancel</button>
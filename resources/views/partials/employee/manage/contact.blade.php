<script type="text/javascript">
    $(document).ready(function(){
        $("#idEmp").val( $('#emp_id').val() );
        $('#contactDtlSave').hide();
        $('#contactDtlCancel').hide();
        $('#editRt').hide();
        $('#addRt').hide();
        $('#contactDtl').click(function(){
            $('#contactForm input[type="text"]').prop("readonly", false);
            $('#contactForm textarea').prop("readonly", false);
            $('#agama').prop("disabled", false);
            $('#coun_code').prop("disabled", false);
            $('#contactDtl').hide();
            $('#contactDtlSave').show();
            $('#contactDtlCancel').show();
            $('#editRt').show();
            $('#addRt').show();
        });
        $('#contactDtlCancel').click(function(){
            $('#contactForm input[type="text"]').prop("readonly", true);
            $('#contactForm textarea').prop("readonly", true);
            $('#agama').prop("disabled", true);
            $('#coun_code').prop("disabled", true);
            $('#contactDtl').show();
            $('#contactDtlSave').hide();
            $('#contactDtlCancel').hide();
            $('#editRt').hide();
            $('#addRt').hide();
        });
        $('#contactDtlSave').click(function (){
            $('form#contactForm').submit();
        });
    });
</script>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<form id="contactForm" action="{{ route('personalEmp.contactDtl') }}" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="emp_number"  id="idEmp" />
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="emp_street1">ID Address</label>
            <textarea class="form-control" type="text" name="emp_street1" id="emp_street1" readonly="readonly">{{ $emp->emp_street1 }}</textarea>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="emp_street2">Residence Address</label>
            <textarea class="form-control" type="text" name="emp_street2" id="emp_street2" readonly="readonly">{{ $emp->emp_street2 }}</textarea>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="city_code">ID City</label>
            <input class="form-control" type="text" name="city_code" id="city_code" value="{{ $emp->city_code }}" readonly="readonly" />
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="city_code_res">Residence City</label>
            <input class="form-control" type="text" name="city_code_res" id="city_code_res" value="{{ $emp->city_code_res }}" readonly="readonly" />
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="provin_code">ID State/Province</label>
            <input class="form-control" type="text" name="provin_code" id="provin_code" value="{{ $emp->provin_code }}" readonly="readonly" />
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="provin_code_res">Residence State/Province</label>
            <input class="form-control" type="text" name="provin_code_res" id="provin_code_res" value="{{ $emp->provin_code_res }}" readonly="readonly" />
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="emp_zipcode">ID Zip/Postal Code</label>
            <input class="form-control" type="text" name="emp_zipcode" id="emp_zipcode" value="{{ $emp->emp_zipcode }}" readonly="readonly" />
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="emp_zipcode_res">Residence Zip/Postal Code</label>
            <input class="form-control" type="text" name="emp_zipcode_res" id="emp_zipcode_res" value="{{ $emp->emp_zipcode_res }}" readonly="readonly" />
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <?php
                $country = \App\Models\Master\Country::lists('name','cou_code')->prepend('-=Pilih=-', '0');
            ?>
            {!! Form::label('coun_code', 'Country') !!}
            {!! Form::select('coun_code', $country, $emp->coun_code, ['class' => 'form-control', 'id' => 'coun_code', 'disabled' => 'disabled']) !!}
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="emp_hm_telephone">Home Telephone</label>
            <input class="form-control" type="text" name="emp_hm_telephone" id="emp_hm_telephone" value="{{ $emp->emp_hm_telephone }}" readonly="readonly" />
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="emp_mobile">Mobile Phone</label>
            <input class="form-control" type="text" name="emp_mobile" id="emp_mobile" value="{{ $emp->emp_mobile }}" readonly="readonly" />
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="emp_mobile2">Mobile Phone Other</label>
            <input class="form-control" type="text" name="emp_mobile2" id="emp_mobile2" value="{{ $emp->emp_mobile2 }}" readonly="readonly" />
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="emp_work_telephone">Work Telephone</label>
            <input class="form-control" type="text" name="emp_work_telephone" id="emp_work_telephone" value="{{ $emp->emp_work_telephone }}" readonly="readonly" />
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="emp_work_email">Work Email</label>
            <input class="form-control" type="text" name="emp_work_email" id="emp_work_email" value="{{ $emp->emp_work_email }}" readonly="readonly" />
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="emp_oth_email">Other Email</label>
            <input class="form-control" type="text" name="emp_oth_email" id="emp_oth_email" value="{{ $emp->emp_oth_email }}" readonly="readonly" />
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <?php
            $agama = \App\Models\Master\Agama::lists('name','id')->prepend('-=Pilih=-', '0');
            ?>
            {!! Form::label('agama', 'Agama') !!}
            {!! Form::select('agama', $agama, $emp->agama, ['class' => 'form-control', 'id' => 'agama', 'disabled' => 'disabled']) !!}
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="emp_facebook">Facebook</label>
            <input class="form-control" type="text" name="emp_facebook" id="emp_facebook" value="{{ $emp->emp_facebook }}" readonly="readonly" />
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="emp_twitter">Twitter</label>
            <input class="form-control" type="text" name="emp_twitter" id="emp_twitter" value="{{ $emp->emp_twitter }}" readonly="readonly" />
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="emp_instagram">Instagram</label>
            <input class="form-control" type="text" name="emp_instagram" id="emp_instagram" value="{{ $emp->emp_instagram }}" readonly="readonly" />
        </div>
    </div>
</form>
</div>
<button class="btn btn-success" id="contactDtl">Edit</button>
<button class="btn btn-primary" id="contactDtlSave">Save</button>
<button class="btn btn-danger" id="contactDtlCancel">Cancel</button>

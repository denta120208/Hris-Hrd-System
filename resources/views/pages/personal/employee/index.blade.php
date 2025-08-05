@extends('_main_layout')

@section('content')
<?php
function date_formated($date){
    $new_date = date('d-m-Y', strtotime(substr($date, 0, 11)));
    return $new_date;
}
?>
<script type="text/javascript">
$(document).ready(function(){
    $(document).on("click", ".open-showModal");
    $('#personal1').addClass("active");
    $('#Home').addClass("in active");
    // $('[data-toggle="tab"]:first').click();
    $('[data-toggle="tab"]').click(function(e) {
        var $this = $(this),
            loadurl = "{{ route('personal') }}" + $this.attr('href'),
            targ = $this.attr('data-target');
        $.get(loadurl, function(data) {
            $(targ).html(data);
        });
        // $('[data-toggle="tab"]:eq(0)').trigger('click');
console.log($this);
        $(this).tab('show');
        return false;
    });
    $('#personalDtlSave').hide();
    $('#personalDtlCancel').hide();
    $('#emp_dri_lice_exp_date').datetimepicker("option", "disabled", true );
    $('#emp_birthday').datetimepicker("option", "disabled", true );
    $('#personalDtl').click(function(){
        $('#personalForm input[type="text"]').prop("readonly", false);
        $('#personalForm select[name="emp_marital_status"]').prop("disabled", false);
        $('#emp_birthday').prop("readonly", true);
        $('#emp_dri_lice_exp_date').prop("readonly", true);
        
        $('#emp_gender').prop("disabled", false);
        $('#nation_code').prop("disabled", false);
        $('#personalDtl').hide();
        $('#personalDtlSave').show();
        $('#personalDtlCancel').show();
        $('#emp_dri_lice_exp_date').datetimepicker({
           format: 'Y-m-d'
        });
        $('#emp_birthday').datetimepicker({
           format: 'Y-m-d'
        });
    });
    $('#personalDtlCancel').click(function(){
        $('#personalForm input[type="text"]').prop("readonly", true);
		$('#personalForm select[name="emp_marital_status"]').prop("disabled", true);
        $('#emp_gender').prop("disabled", true);
        $('#nation_code').prop("disabled", true);
        $('#personalDtl').show();
        $('#personalDtlSave').hide();
        $('#personalDtlCancel').hide();
        $('#emp_dri_lice_exp_date').datetimepicker("option", "disabled", true );
        $('#emp_birthday').datetimepicker("option", "disabled", true );
    });
    $('#personalDtlSave').click(function (){
        $('form#personalForm').submit();
    });
    
    
    
//    $('#econ_extend_start_date').datetimepicker({
//        format: 'yyyy-mm-dd',
//    });
//    $('#econ_extend_end_date').datetimepicker({
//        format: 'yyyy-mm-dd',
//    });

});

</script>
        <div class="container">
            <input type="hidden" id="addClasses" value="active" />
            <div class="row">
                <h1>{{ $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname }}</h1>
                <div style="margin-top: 70px;" class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    @if($pic)
                        @if($pic->epic_picture_type == '2')
                            <img style="height: 250px;width: 450px;" class="img-responsive img-thumbnail" src="data:image/jpeg;base64,{{ base64_encode($pic->epic_picture) }}"/>
                        @elseif($pic->epic_picture_type == '1')
                            <img style="height: 250px;width: 450px;" class="img-responsive img-thumbnail" src="data:image/jpeg;base64,{{ $pic->epic_picture }}"/>
                        @else
                            <img src="{{ asset('images\personal\FOTO_DEFAULT.gif') }}">
                        @endif
                    @else
                        <img src="{{ asset('images\personal\FOTO_DEFAULT.gif') }}">
                    @endif
                    @if($termination_upload)
			<a id="show" href="/printExitFormInterview" target="_blank" data-toggle="modal"  style="margin-top: 10px;" class="btn btn-primary btn-block d-flex">Print Exit Form</a>
                    @elseif($termination_exist)
                        <button disabled id="show" href="#" data-toggle="modal"  style="margin-top: 10px;" class="btn btn-block d-flex">Request on process</button>
		    @else
                        <a id="show" href="#showModal" data-toggle="modal"  style="margin-top: 10px;" class="btn btn-primary btn-block open-showModal d-flex">Request Resign</a>
                    @endif              
                </div>
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                    <div class="widget-tabs-int">
                        <div class="widget-tabs-list">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#personal1">Personal Details</a></li>
                                <li><a data-toggle="tab" href="/job/{{ $emp->emp_number }}" data-target="#job">Job</a></li>
                                <li><a data-toggle="tab" href="/contact/{{ $emp->emp_number }}" data-target="#contact">Contact Details</a></li>
                                <li><a data-toggle="tab" href="/dependents/{{ $emp->emp_number }}" data-target="#dependents">Dependents</a></li>
                                <li><a data-toggle="tab" href="/emergency/{{ $emp->emp_number }}" data-target="#emergency">Emergency Contact</a></li>
                                <li><a data-toggle="tab" href="/qualifications/{{ $emp->emp_number }}" data-target="#qualifications">Qualifications</a></li>
                                <li><a data-toggle="tab" href="/reward/{{ $emp->emp_number }}" data-target="#reward">Reward & Punishment</a></li>
{{--                                <li><a data-toggle="tab" href="/immigration/{{ $emp->emp_number }}" data-target="#immigration">Immigration</a></li>--}}
{{--                                <li><a data-toggle="tab" href="/salary/{{ $emp->emp_number }}" data-target="#salary">Salary</a></li>--}}
{{--                                <li><a data-toggle="tab" href="/reportTo/{{ $emp->emp_number }}" data-target="#reportTo">Report-to</a></li>--}}
                            </ul>
                            <div class="tab-content tab-custom-st">
                                <div id="personal1" class="tab-pane fade in active">
                                    <div class="tab-ctn">
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
                                                    <label for="employee_id">Employee Id</label>
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
                                                    <label for="emp_dri_lice_exp_date">License Expiry Date</label><?php $dri_lice_exp_date = date_formated($emp->emp_dri_lice_exp_date);?>
                                                    <input class="form-control" type="text" name="emp_dri_lice_exp_date" id="emp_dri_lice_exp_date" value="<?php if($dri_lice_exp_date != '01-01-1970' && $dri_lice_exp_date != '01-01-1900') {echo date_formated($emp->emp_dri_lice_exp_date);} ?>" readonly="readonly" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label for="emp_marital_status">Marital Status</label>
                                                    {{-- <input class="form-control" type="text" name="emp_marital_status" id="emp_marital_status" value="{{ $emp->emp_marital_status }}" readonly="readonly" /> --}}
                                                    <select class="form-control" name="emp_marital_status" id="emp_marital_status" required disabled>
                                                        <option value="">-- Not Selected --</option>
                                                        <option value="Lajang" {{ $emp->emp_marital_status == "Lajang" ? "selected" : "" }}>Lajang</option>
                                                        <option value="Menikah" {{ $emp->emp_marital_status == "Menikah" ? "selected" : "" }}>Menikah</option>
                                                        <option value="Cerai" {{ $emp->emp_marital_status == "Cerai" ? "selected" : "" }}>Cerai</option>
                                                        <option value="Janda/Duda" {{ $emp->emp_marital_status == "Janda/Duda" ? "selected" : "" }}>Janda/Duda</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label for="emp_birthday">Date of Birth</label><?php $birth_day = date_formated($emp->emp_birthday);?>
                                                    <input class="form-control" type="text" name="emp_birthday" id="emp_birthday" value="<?php if($birth_day != '01-01-1970' && $birth_day != '01-01-1900'){echo date_formated($emp->emp_birthday);} ?>" readonly="readonly" />
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
                                                    <label for="bpjs_tk">BPJS TKsss</label>
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
                                        <button class="btn btn-success" id="personalDtl">Edit</button>
                                        <button class="btn btn-primary" id="personalDtlSave">Save</button>
                                        <button class="btn btn-danger" id="personalDtlCancel">Cancel</button>
                                    </div>
                                </div>
                                <div id="contact" class="tab-pane fade">
                                    <div class="tab-ctn">
                                    </div>
                                </div>
                                <div id="emergency" class="tab-pane fade">
                                    <div class="tab-ctn">
                                    </div>
                                </div>
                                <div id="dependents" class="tab-pane fade">
                                    <div class="tab-ctn">
                                    </div>
                                </div>
                                <div id="immigration" class="tab-pane fade">
                                    <div class="tab-ctn">
                                        <p>Duis arcu tortor, suscipit eget, imperdiet nec, imperdiet iaculis, ipsum. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Nulla sit amet est. Praesent ac the massa at ligula laoreet iaculis. Vivamus aliquet elit ac nisl. Nulla porta dolor. Cras dapibus. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.</p>
                                        <p class="tab-mg-b-0">In hac habitasse platea dictumst. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Nam eget dui. In ac felis quis tortor malesuadan of pretium. Phasellus consectetuer vestibulum elit. Duis lobortis massa imperdiet quam. Pellentesque commodo eros a enim. Vestibulum ante ipsum primis in faucibus orci the luctus et ultrices posuere cubilia Curae; In ac dui quis mi consectetuer lacinia. Phasellus a est. Pellentesque commodo eros a enim. Cras ultricies mi eu turpis hendrerit of fringilla. Donec mollis hendrerit risus. Vestibulum turpis sem, aliquet eget, lobortis pellentesque, rutrum eu, nisl. Praesent egestas neque eu enim. In hac habitasse plat.</p>
                                    </div>
                                </div>
                                <div id="job" class="tab-pane fade">
                                    <div class="tab-ctn">
                                        <p>Duis arcu tortor, suscipit eget, imperdiet nec, imperdiet iaculis, ipsum. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Nulla sit amet est. Praesent ac the massa at ligula laoreet iaculis. Vivamus aliquet elit ac nisl. Nulla porta dolor. Cras dapibus. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.</p>
                                        <p class="tab-mg-b-0">In hac habitasse platea dictumst. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Nam eget dui. In ac felis quis tortor malesuadan of pretium. Phasellus consectetuer vestibulum elit. Duis lobortis massa imperdiet quam. Pellentesque commodo eros a enim. Vestibulum ante ipsum primis in faucibus orci the luctus et ultrices posuere cubilia Curae; In ac dui quis mi consectetuer lacinia. Phasellus a est. Pellentesque commodo eros a enim. Cras ultricies mi eu turpis hendrerit of fringilla. Donec mollis hendrerit risus. Vestibulum turpis sem, aliquet eget, lobortis pellentesque, rutrum eu, nisl. Praesent egestas neque eu enim. In hac habitasse plat.</p>
                                    </div>
                                </div>
                                <div id="salary" class="tab-pane fade">
                                    <div class="tab-ctn">
                                        <p>Duis arcu tortor, suscipit eget, imperdiet nec, imperdiet iaculis, ipsum. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Nulla sit amet est. Praesent ac the massa at ligula laoreet iaculis. Vivamus aliquet elit ac nisl. Nulla porta dolor. Cras dapibus. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.</p>
                                        <p class="tab-mg-b-0">In hac habitasse platea dictumst. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Nam eget dui. In ac felis quis tortor malesuadan of pretium. Phasellus consectetuer vestibulum elit. Duis lobortis massa imperdiet quam. Pellentesque commodo eros a enim. Vestibulum ante ipsum primis in faucibus orci the luctus et ultrices posuere cubilia Curae; In ac dui quis mi consectetuer lacinia. Phasellus a est. Pellentesque commodo eros a enim. Cras ultricies mi eu turpis hendrerit of fringilla. Donec mollis hendrerit risus. Vestibulum turpis sem, aliquet eget, lobortis pellentesque, rutrum eu, nisl. Praesent egestas neque eu enim. In hac habitasse plat.</p>
                                    </div>
                                </div>
{{--                                <div id="reportTo" class="tab-pane fade">--}}
{{--                                    <div class="tab-ctn">--}}
{{--                                        <p>Duis arcu tortor, suscipit eget, imperdiet nec, imperdiet iaculis, ipsum. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Nulla sit amet est. Praesent ac the massa at ligula laoreet iaculis. Vivamus aliquet elit ac nisl. Nulla porta dolor. Cras dapibus. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.</p>--}}
{{--                                        <p class="tab-mg-b-0">In hac habitasse platea dictumst. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Nam eget dui. In ac felis quis tortor malesuadan of pretium. Phasellus consectetuer vestibulum elit. Duis lobortis massa imperdiet quam. Pellentesque commodo eros a enim. Vestibulum ante ipsum primis in faucibus orci the luctus et ultrices posuere cubilia Curae; In ac dui quis mi consectetuer lacinia. Phasellus a est. Pellentesque commodo eros a enim. Cras ultricies mi eu turpis hendrerit of fringilla. Donec mollis hendrerit risus. Vestibulum turpis sem, aliquet eget, lobortis pellentesque, rutrum eu, nisl. Praesent egestas neque eu enim. In hac habitasse plat.</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <div id="qualifications" class="tab-pane fade">
                                    <div class="tab-ctn">
                                        <p>Duis arcu tortor, suscipit eget, imperdiet nec, imperdiet iaculis, ipsum. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Nulla sit amet est. Praesent ac the massa at ligula laoreet iaculis. Vivamus aliquet elit ac nisl. Nulla porta dolor. Cras dapibus. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.</p>
                                        <p class="tab-mg-b-0">In hac habitasse platea dictumst. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Nam eget dui. In ac felis quis tortor malesuadan of pretium. Phasellus consectetuer vestibulum elit. Duis lobortis massa imperdiet quam. Pellentesque commodo eros a enim. Vestibulum ante ipsum primis in faucibus orci the luctus et ultrices posuere cubilia Curae; In ac dui quis mi consectetuer lacinia. Phasellus a est. Pellentesque commodo eros a enim. Cras ultricies mi eu turpis hendrerit of fringilla. Donec mollis hendrerit risus. Vestibulum turpis sem, aliquet eget, lobortis pellentesque, rutrum eu, nisl. Praesent egestas neque eu enim. In hac habitasse plat.</p>
                                    </div>
                                </div>
                                <div id="reward" class="tab-pane fade">
                                    <div class="tab-ctn">
                                        <p>Duis arcu tortor, suscipit eget, imperdiet nec, imperdiet iaculis, ipsum. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Nulla sit amet est. Praesent ac the massa at ligula laoreet iaculis. Vivamus aliquet elit ac nisl. Nulla porta dolor. Cras dapibus. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.</p>
                                        <p class="tab-mg-b-0">In hac habitasse platea dictumst. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Nam eget dui. In ac felis quis tortor malesuadan of pretium. Phasellus consectetuer vestibulum elit. Duis lobortis massa imperdiet quam. Pellentesque commodo eros a enim. Vestibulum ante ipsum primis in faucibus orci the luctus et ultrices posuere cubilia Curae; In ac dui quis mi consectetuer lacinia. Phasellus a est. Pellentesque commodo eros a enim. Cras ultricies mi eu turpis hendrerit of fringilla. Donec mollis hendrerit risus. Vestibulum turpis sem, aliquet eget, lobortis pellentesque, rutrum eu, nisl. Praesent egestas neque eu enim. In hac habitasse plat.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div id="showModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="showModal" aria-hidden="true">
        <div class="modal-dialog modal-xtra-large">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                    <h4 class="modal-title" id="showModal">Detail Request</h4>
                </div>
                <div class="modal-body">
		<form id="requestResignForm" action="{{ route('requestResign') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input class="form-control" type="text" name="emp_number" id="emp_number" hidden value="{{$emp->emp_number}}"/>
                <input class="form-control" type="text" name="emp_number_old" id="emp_number_old" hidden value="{{$emp->emp_number}}"/>
                    <div class="form-group">
                        <label for="reason_id">Reason</label>
                        <select class="form-control" aria-label="Default select example" id="reason_id" name="reason_id" required="">
                            	@foreach($termination_reason as $a)
					<option value="{{$a->id}}">{{$a->name}}</option>
				@endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="termination_date">Date</label>
                        <input class="form-control" type="date" name="termination_date" id="termination_date" required=""/>
                    </div>
                    <div class="form-group">
                        <label for="emp_dri_lice_exp_date">Note</label>
                        <textarea class="form-control" name="note" id="note" rows="3"></textarea>
                    </div>
		<br>
		<button type="submit" class="btn btn-primary">Request</button>
		</form>
                </div>
            </div>
        </div>
    </div>
{{--<script type="text/javascript">--}}
{{--</script>--}}
@endsection
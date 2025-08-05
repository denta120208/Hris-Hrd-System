@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function(){
        $('#sTrain_date').datetimepicker({
            format: 'Y-m-d H:i:s'
        });
        $('#eTrain_date').datetimepicker({
            format: 'Y-m-d H:i:s'
        });
        // $('#activeClass ul li').addClass($('addClasses').val());
        $("#train_id").change(function(){
            var id = $(this).val();
            $.ajax({
                url: '{{ route('getVendorTrain') }}',
                type: 'get',
                data: {id:id},
                dataType: 'json',
                success:function(data){
                    $('#vendor_id').html(data['html']);
                }
            });
            $('#training_id').val(id);
        });
    });
</script>
    <div class="container">
        <input type="hidden" id="addClasses" value="active" />
        <div class="row">
            <br /><br />
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <form action="{{ route('saveTraining') }}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <div class="nk-int-st">
                                <label for="name">Name</label>
                                <input class="form-control" type="text" name="name" id="name" value="{{ $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname }}" disabled="disabled" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <div class="nk-int-st">
                                <label for="emp_department">Department</label>
                                <input class="form-control" type="text" name="emp_department" id="emp_department" value="" disabled="disabled" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <div class="date nk-int-st">
                                <label for="job_level">Position</label>
                                <input class="form-control" type="text" name="job_level" id="job_level" value="{{ $emp->job_title->job_title }}" disabled="disabled"" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <div class="date nk-int-st">
                                <label for="joined_date">Joined Date</label>
                                <input class="form-control" type="text" name="joined_date" id="joined_date" value="{{ $emp->joined_date }}" disabled="disabled" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                        <div class="form-group">
                            <div class="date nk-int-st">
                                <label for="sTrain_date">Training Start Date</label>
                                <input class="form-control" type="text" name="sTrain_date" id="sTrain_date" readonly="readonly" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                        <div class="form-group">
                            <div class="date nk-int-st">
                                <label for="eTrain_date">Training End Date</label>
                                <input class="form-control" type="text" name="eTrain_date" id="eTrain_date" readonly="readonly" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                        <div class="form-group">
                            <div class="nk-int-st">
                                <label for="trainning_costs">Training Cost</label>
                                <input class="form-control" type="number" name="trainning_costs" id="trainning_costs" />
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <div class="date nk-int-st">
                                <?php
                                $training = \App\Models\Trainning\Trainning::lists('name','id')->prepend('-=Pilih=-', '0');
                                ?>
                                {!! Form::label('train_id', 'Training Topic') !!}
                                {!! Form::select('train_id', $training, null, ['class' => 'form-control', 'id' => 'train_id']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label for="vendor_id">Institution</label>
                        <div class="input-group">
                            <div class="date nk-int-st">
                                <?php
                                $trainingVendor = \App\Models\Trainning\TrainningVendor::lists('vendor_name','id')->prepend('-=Pilih=-', '0');
                                ?>
                                {!! Form::select('vendor_id', $trainingVendor, null, ['class' => 'form-control', 'id' => 'vendor_id']) !!}
                            </div>
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" data-toggle="modal" data-target="#new_vendor">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <div class="nk-int-st">
                                <label for="trainning_silabus">Training Silabus</label>
                                <textarea class="form-control" rows="6" name="trainning_silabus" id="trainning_silabus"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <div class="nk-int-st">
                                <label for="trainning_purpose">Training Purpose</label>
                                <textarea class="form-control" rows="6" name="trainning_purpose" id="trainning_purpose"></textarea>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary pull-right">Request</button>
                </form>
            </div>
        </div>
    </div>
<!-- Modal -->
<div class="modal" id="new_vendor" tabindex="-1" role="dialog" aria-labelledby="newVendorLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{ route('setVendorTrain') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="training_id" id="training_id" />
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h3 class="modal-title" id="newVendorLabel">Add Institutions</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="vendor_name">Institution Name</label>
                        <input class="form-control" type="text" name="vendor_name" id="vendor_name" />
                    </div>
                    <div class="form-group">
                        <label for="vendor_addr">Institution Address</label>
                        <textarea class="form-control" rows="5" name="vendor_addr" id="vendor_addr"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="vendor_tlp">Institution Phone</label>
                        <input class="form-control" type="text" name="vendor_tlp" id="vendor_tlp" />
                    </div>
                    <div class="form-group">
                        <label for="vendor_fax">Institution Fax</label>
                        <input class="form-control" type="text" name="vendor_fax" id="vendor_fax" />
                    </div>
                    <div class="form-group">
                        <label for="vendor_email">Institution Email</label>
                        <input class="form-control" type="text" name="vendor_email" id="vendor_email" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
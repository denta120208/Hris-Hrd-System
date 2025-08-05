<script type="text/javascript">
    $(document).ready(function(){
        $('#closePromotionModal').on('click', function () {
            $('#edtModalPr').modal('hide');
        });
        $('#closeRewardModal').on('click', function () {
            $('#edtModalRw').modal('hide');
        });
        $('#closePunishmentModal').on('click', function () {
            $('#edtModalPh').modal('hide');
        });
        $('#rewardDtlSave').hide();
        $('#rewardDtlCancel').hide();
        $('#promotDtlSave').hide();
        $('#promotDtlCancel').hide();
        $('#punishDtlSave').hide();
        $('#punishDtlCancel').hide();
        $('#editRw').hide();
        $('#addRw').hide();
        $('#editPr').hide();
        $('#addPr').hide();
        $('.editPunish').hide();
        $('#addPunish').hide();
        $('#rewardDtl').click(function(){
            $('#rewardDtl').hide();
            $('#rewardDtlSave').show();
            $('#rewardDtlCancel').show();
            $('#editRw').show();
            $('#addRw').show();
        });
        $('#rewardDtlCancel').click(function(){
            $('#rewardDtl').show();
            $('#rewardDtlSave').hide();
            $('#rewardDtlCancel').hide();
            $('#editRw').hide();
            $('#addRw').hide();
            $('#rewards_id').val('');
            $('#employee_id').val('');
            $('#year_reward').val('');
        });
        $('#promotDtl').click(function(){
            $('#promotDtl').hide();
            $('#promotDtlSave').show();
            $('#promotDtlCancel').show();
            $('#editPr').show();
            $('#addPr').show();
        });
        $('#promotDtlCancel').click(function(){
            $('#promotDtl').show();
            $('#promotDtlSave').hide();
            $('#promotDtlCancel').hide();
            $('#editPr').hide();
            $('#addPr').hide();
        });

        $('#punishtDtl').click(function(){
            $('#punishtDtl').hide();
            $('#punishDtlSave').show();
            $('#punishDtlCancel').show();
            $('.editPunish').show();
            $('#addPunish').show();
        });

        $('#punishDtlCancel').click(function(){
            $('#punishtDtl').show();
            $('#punishDtlSave').hide();
            $('#punishDtlCancel').hide();
            $('.editPunish').hide();
            $('#addPunish').hide();
        });

        $('#emergencyDtlSave').click(function (){
            $('form#emergencyForm').submit();
        });
        $(document).on("click", ".open-edtModalRw", function () {
            var id = $(this).data('id');
            $(".modal-body #emp_idRw").val( $('#emp_id').val() );
            $(".modal-body #idPr").val( id );
            if(id > 0){
                $.ajax({
                    url: '{{ route('personalEmp.getRewardDtl') }}',
                    type: 'get',
                    data: {id:id},
                    dataType: 'json',
                    success:function(data){
                        $('#rewards_id').val(data['rewards_id']);
                        $('#employee_id').val(data['employee_id']);
                        $('#year_reward').val(data['year_reward']);
                    }
                });
            }
            $('#rewards_id').val('');
            $('#employee_id').val('');
            $('#year_reward').val('');
        });
        $(document).on("click", ".open-edtModalPr", function () {
            var id = $(this).data('id');
            $(".modal-body #idPr").val( $(this).data('id') );
            $(".modal-body #emp_idPr").val( $('#emp_id').val() );
            if(id > 0){
                $.ajax({
                    url: '{{ route('personalEmp.getPromotDtl') }}',
                    type: 'get',
                    data: {id:id},
                    dataType: 'json',
                    success:function(data){
                        $('#emp_idPr').val(data['emp_number']);
                        $('#promotion_date').val(data['promotion_date']);
                        $('#promotion_from').val(data['promotion_from']);
                        $('#promotion_to').val(data['promotion_to']);
                    }
                });
            }
        });
        $(document).on("click", ".open-edtModalPh", function () {
            var id = $(this).data('id');
            $(".modal-body #idPh").val($(this).data('id'));
            $(".modal-body #emp_idPh").val($('#emp_id').val());
            if(id > 0) {
                $.ajax({
                    url: '{{ route('personalEmp.getPunishDtl') }}',
                    type: 'get',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#punishment_date').val(data['TRX_DATE']);
                        $('#punish_type').val(data['punish_type']);
                        $('#punish_status').val(data['punish_status']);
                        $('#punish_reason').val(data['punish_reason']);
                    }
                });
            }
            else {
                $('#punishment_date').val(null);
                $('#punish_type').val(null);
                $('#punish_status').val(null);
                $('#punish_reason').val(null);
            }
        });
        $('#promotion_date').datetimepicker({
            format: 'Y-m-d',
        });
    });
</script>
<div>
<?php
//    print_r($emp->emp_birthday);
function date_formated($date){
    $new_date = date('d-m-Y', strtotime(substr($date, 0, 11)));
    return $new_date;
}
?>
<div class="table-responsive">
    <h4>Reward</h4>
    <a href="#edtModalRw" data-toggle="modal" class="open-edtModalRw" data-id="0"><i class="fa fa-2x fa-plus-square-o" title="Add" id="addRw"></i></a>
    <table id="data-table-basic" class="table table-striped">
        <thead>
        <tr>
            <th>No</th>
            <th>Reward Type</th>
            <th>Year</th>
        </tr>
        </thead>
        <tbody>
        @if(!empty($eRewards))
            <?php $no = 1;?>
            @foreach($eRewards as $row)
        <tr>
            <td>{{ $no }}</td>
            <td>{{ $row->reward_name->name }}</td>
            <td>{{ $row->year_reward }}</td>
            <td><a href="#edtModalRw" data-toggle="modal" class="open-edtModalRw" data-id="{{ $row->id }}"><i class="fa fa-check-circle" title="Edit" id="editRw"></i></a></td>
        </tr>
        <?php $no++;?>
            @endforeach
        @else
            <tr><td colspan="3">No Data</td></tr>
        @endif
        </tbody>
    </table>
    <button class="btn btn-success" id="rewardDtl">Edit</button>
    <button class="btn btn-primary" id="rewardDtlSave">Save</button>
    <button class="btn btn-danger" id="rewardDtlCancel">Cancel</button>
</div>
<br>
<div>
    <div class="table-responsive">
        <h4>Promotions</h4>
        <a href="#edtModalPr" data-toggle="modal" class="open-edtModalPr" data-id="0"><i class="fa fa-2x fa-plus-square-o" title="Add" id="addPr"></i></a>
        <table id="data-table-basic" class="table table-striped">
            <thead>
            <tr>
                <th>No</th>
                <th>Employee Name</th>
                <th>NIK</th>
                <th>Promotion Date</th>
                <th>From</th>
                <th>To</th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($ePromots))
                <?php $no = 1;?>
                @foreach($ePromots as $row)
                <tr>
                    <td>{{ $no }}</td>
                    <td>{{ $row->name->emp_firstname.' '.$row->name->emp_middle_name.' '.$row->name->emp_lastname }}</td>
                    <td>{{ $row->name->employee_id }}</td>
                    <td>{{ date_formated($row->promotion_date) }}</td>
                    <td>{{ $row->promotion_from }}</td>
                    <td>{{ $row->promotion_to }}</td>
                    <td><a href="#edtModalPr" data-toggle="modal" class="open-edtModalPr" data-id="{{ $row->id }}"><i class="fa fa-check-circle" title="Edit" id="editPr"></i></a></td>
                    <?php $no++;?>
                </tr>
                @endforeach
            @else
            <tr><td colspan="6">No Data</td></tr>
            @endif
            </tbody>
        </table>
    </div>
    <button class="btn btn-success" id="promotDtl">Edit</button>
    <button class="btn btn-primary" id="promotDtlSave">Save</button>
    <button class="btn btn-danger" id="promotDtlCancel">Cancel</button>
</div>
<br>
<div>
    <div class="table-responsive">
        <h4>Punishment</h4>
        <a href="#edtModalPh" data-toggle="modal" class="open-edtModalPh" data-id="0"><i class="fa fa-2x fa-plus-square-o" title="Add" id="addPunish"></i></a>
        <table id="data-table-basic" class="table table-striped">
            <thead>
            <tr>
                <th>No</th>
                <th>Punishment Type</th>
                <th>Reason</th>
                <th>Year</th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($ePunish))
                <?php $noPunish = 1;?>
                @foreach($ePunish as $punish)
                <tr>
                    <td>{{ $noPunish }}</td>
                    <td>{{ $punish->punish_type }}</td>
                    <td>{{ $punish->punish_reason }}</td>
                    <td>{{ $punish->year_punish }}</td>
                    <td><a href="#edtModalPh" data-toggle="modal" class="open-edtModalPh editPunish" data-id="{{ $punish->id }}"><i class="fa fa-check-circle" title="Edit" id="editPunish"></i></a></td>
                    <?php $noPunish++; ?>
                </tr>
                @endforeach
            @else
            <tr><td colspan="4">No Data</td></tr>
            @endif
            </tbody>
        </table>
    </div>
    <button class="btn btn-success" id="punishtDtl">Edit</button>
    <button class="btn btn-primary" id="punishDtlSave">Save</button>
    <button class="btn btn-danger" id="punishDtlCancel">Cancel</button>
</div>
</div>
<div id="edtModalRw" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edtModalRw" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                <h4 class="modal-title" id="edtModalRw">Reward</h4>
            </div>
            <form action="{{ route('personalEmp.setReward') }}" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="idPr" id="idPr" />
                    <input type="hidden" name="emp_idRw" id="emp_idRw" />
                    <input type="hidden" name="employee_id" id="employee_id" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="form-group">
                        <?php $rewards = App\Models\Master\Reward::lists('name', 'id')->prepend('-=Pilih=-', '0');?>
                            {!! Form::label('rewards_id', 'Reward Name') !!}
                            {!! Form::select('rewards_id', $rewards, null, ['class' => 'form-control', 'id' => 'rewards_id']) !!}
                    </div>
                    <div class="form-group">
                        <label for="year_reward">Year</label>
                        <input class="form-control" type="text" name="year_reward" id="year_reward" />
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> --}}
                        <button type="button" class="btn btn-default" id="closeRewardModal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="edtModalPr" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edtModalPr" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                <h4 class="modal-title" id="edtModalPr">Promotion</h4>
            </div>
            <form action="{{ route('personalEmp.setPromotDtl') }}" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="idPr" id="idPr" />
                    <input type="hidden" name="emp_idPr" id="emp_idPr" />
                    <div class="form-group">
                        <label for="promotion_date">Promotion Date</label>
                        <input class="form-control" type="text" name="promotion_date" id="promotion_date" />
                    </div>
                    <div class="form-group">
                        <label for="promotion_from">Promotion From</label>
                        <input class="form-control" type="text" name="promotion_from" id="promotion_from" />
                    </div>
                    <div class="form-group">
                        <label for="promotion_to">Promotion To</label>
                        <input class="form-control" type="text" name="promotion_to" id="promotion_to" />
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> --}}
                        <button type="button" class="btn btn-default" id="closePromotionModal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="edtModalPh" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edtModalPh" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                <h4 class="modal-title" id="edtModalPh">Punishment</h4>
            </div>
            <form action="{{ route('personalEmp.setPunishDtl') }}" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="idPh" id="idPh" />
                    <input type="hidden" name="emp_idPh" id="emp_idPh" />
                    <div class="form-group">
                        <label for="promotion_date">Punishment Date</label>
                        <input class="form-control" type="date" name="punishment_date" id="punishment_date" required />
                    </div>
                    <div class="form-group">
                        <label for="promotion_from">Punishment Type</label>
                        <select class="form-control" name="punish_type" id="punish_type" required>
                            @foreach($punishment_type as $data)
                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="promotion_date">Punishment Reason</label>
                        <input class="form-control" type="text" name="punish_reason" id="punish_reason" required />
                    </div>
                    <div class="form-group">
                        <label for="promotion_to">Punishment Status</label>
                        <select class="form-control" name="punish_status" id="punish_status" required>
                            <option value="3">HR APPROVED</option>
                            <option value="5">REJECTED</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" id="closePunishmentModal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
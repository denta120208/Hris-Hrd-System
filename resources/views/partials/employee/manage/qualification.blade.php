<?php

function date_formated($date) {
    $new_date = date('d-m-Y', strtotime(substr($date, 0, 11)));
    return $new_date;
}
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#addEdu').hide();
        $('#addWork').hide();
        $('#addTrain').hide();
        $('#eduDtlSave').hide();
        $('#eduDtlCancel').hide();
        $('#workDtlSave').hide();
        $('#workDtlCancel').hide();
        $('#trainDtlSave').hide();
        $('#trainDtlCancel').hide();
        $('.deleteButton').hide();
        $('.editItemButton').hide();
        // Pastikan tombol Cancel sembunyi di awal
        $('#eduDtlCancel').hide();
        $('#workDtlCancel').hide();
        $('#trainDtlCancel').hide();
        
        $('#start_date').datetimepicker({
            format: 'Y-m-d',
        });
        $('#end_date').datetimepicker({
            format: 'Y-m-d',
        });
        $('#eexp_from_date').datetimepicker({
            format: 'Y-m-d',
        });
        $('#eexp_to_date').datetimepicker({
            format: 'Y-m-d',
        });
        
        // Handle Delete dengan AJAX
        $('.deleteButton').click(function(e) {
            e.preventDefault();
            var deleteUrl = $(this).data('url');
            $.ajax({
                url: deleteUrl,
                type: 'GET',
                success: function(response) {
                    window.location.href = '{{ route("hrd.employee") }}';
                }
            });
        });

        // Handle Save Education dengan AJAX
        $('form#addEdu').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    window.location.href = '{{ route("hrd.employee") }}';
                }
            });
        });

        // Handle Save Work dengan AJAX
        $('form#addWork').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    window.location.href = '{{ route("hrd.employee") }}';
                }
            });
        });

        // Handle Save Training dengan AJAX
        $('form#addTrain').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    window.location.href = '{{ route("hrd.employee") }}';
                }
            });
        });

        // Handle Add New buttons
        $('#addNewEdu').click(function() {
            $('#idEduEmp').val($('#emp_id').val());
            clearEducationForm();
            $('#addEdu').show();
            $('#eduDtlSave').show();
            $('#eduDtlCancel').show();
            $('.deleteButton.edu').hide();
            $('.editItemButton.edu').hide();
            $('#editDtlEdu').show();
            $('#cancelEditEdu').hide();
        });

        // Ketika klik tombol Edit (di samping Add New)
        $('#editDtlEdu').click(function() {
            $(this).hide();
            $('#cancelEditEdu').show();
        });

        $('#addNewWork').click(function() {
            $('#idWorkEmp').val($('#emp_id').val());
            clearWorkForm();
            $('#addWork').show();
            $('#workDtlSave').show();
            $('#workDtlCancel').show();
            $('.deleteButton.work').hide();
            $('.editItemButton.work').hide();
            $('#editDtlWork').show();
            $('#cancelEditWork').hide();
        });

        // Ketika klik tombol Edit (Work)
        $('#editDtlWork').click(function() {
            $(this).hide();
            $('#cancelEditWork').show();
        });

        $('#addNewTrain').click(function() {
            $('#idTrainEmp').val($('#emp_id').val());
            clearTrainingForm();
            $('#addTrain').show();
            $('#trainDtlSave').show();
            $('#trainDtlCancel').show();
            $('.deleteButton.train').hide();
            $('.editItemButton.train').hide();
            $('#editDtlTrain').show();
            $('#cancelEditTrain').hide();
        });

        // Ketika klik tombol Edit (Train)
        $('#editDtlTrain').click(function() {
            $(this).hide();
            $('#cancelEditTrain').show();
        });

        // Handle Edit buttons
        $('#editDtlEdu').click(function(){
            $('.deleteButton.edu').show();
            $('.editItemButton.edu').show();
            $('#editDtlEdu').hide();
            $('#addEdu').hide();
        });

        $('#editDtlWork').click(function(){
            $('.deleteButton.work').show();
            $('.editItemButton.work').show();
            $('#editDtlWork').hide();
            $('#addWork').hide();
        });

        $('#editDtlTrain').click(function(){
            $('.deleteButton.train').show();
            $('.editItemButton.train').show();
            $('#editDtlTrain').hide();
            $('#addTrain').hide();
        });

        // Handle edit item clicks
        $('.editItemButton.edu').click(function(e) {
            e.preventDefault();
            $('#idEduEmp').val($('#emp_id').val());
            
            // Mengisi form dengan data yang ada
            $('#education_id').val($(this).data('education'));
            $('#institute').val($(this).data('institute'));
            $('#major').val($(this).data('major'));
            $('#year').val($(this).data('year'));
            $('#score').val($(this).data('score'));
            $('#start_date').val(formatDate($(this).data('start')));
            $('#end_date').val(formatDate($(this).data('end')));
            
            $('#addEdu').show();
            $('#eduDtlSave').show();
            $('#eduDtlCancel').show();
        });

        $('.editItemButton.work').click(function(e) {
            e.preventDefault();
            $('#idWorkEmp').val($('#emp_id').val());
            
            $('#eexp_employer').val($(this).data('employer'));
            $('#eexp_jobtit').val($(this).data('jobtitle'));
            $('#eexp_from_date').val(formatDate($(this).data('fromdate')));
            $('#eexp_to_date').val(formatDate($(this).data('todate')));
            $('#eexp_comments').val($(this).data('comments'));
            
            $('#addWork').show();
            $('#workDtlSave').show();
            $('#workDtlCancel').show();
        });

        $('.editItemButton.train').click(function(e) {
            e.preventDefault();
            $('#idTrainEmp').val($('#emp_id').val());
            
            $('#train_name').val($(this).data('name'));
            $('#license_no').val($(this).data('licenseno'));
            $('#license_issued_date').val(formatDate($(this).data('issueddate')));
            $('#license_expiry_date').val(formatDate($(this).data('expirydate')));
            
            $('#addTrain').show();
            $('#trainDtlSave').show();
            $('#trainDtlCancel').show();
        });

        // Handle Cancels
        $('#eduDtlCancel').click(function(){
            $('#addEdu').hide();
            $('#editDtlEdu').show();
            $('#eduDtlSave').hide();
            $('#eduDtlCancel').hide();
            $('.deleteButton.edu').hide();
            $('.editItemButton.edu').hide();
            // Reset form jika perlu
            clearEducationForm();
            $('#cancelEditEdu').hide();
            $('#editDtlEdu').show();
        });

        // Cancel di samping Add New (mode edit)
        $('#cancelEditEdu').click(function(){
            $('#addEdu').hide();
            $('#editDtlEdu').show();
            $('#eduDtlSave').hide();
            $('#eduDtlCancel').hide();
            $('.deleteButton.edu').hide();
            $('.editItemButton.edu').hide();
            clearEducationForm();
            $('#cancelEditEdu').hide();
            $('#editDtlEdu').show();
        });

        // Cancel di samping Add New (mode edit)
        $('#cancelEditEdu').click(function(){
            $('#addEdu').hide();
            $('#editDtlEdu').show();
            $('#eduDtlSave').hide();
            $('#eduDtlCancel').hide();
            $('.deleteButton.edu').hide();
            $('.editItemButton.edu').hide();
            clearEducationForm();
            $('#cancelEditEdu').hide();
        });

        $('#workDtlCancel').click(function(){
            $('#addWork').hide();
            $('#editDtlWork').show();
            $('#workDtlSave').hide();
            $('#workDtlCancel').hide();
            $('.deleteButton.work').hide();
            $('.editItemButton.work').hide();
            clearWorkForm();
            $('#cancelEditWork').hide();
            $('#editDtlWork').show();
        });

        // Cancel di samping Add New (Work)
        $('#cancelEditWork').click(function(){
            $('#addWork').hide();
            $('#editDtlWork').show();
            $('#workDtlSave').hide();
            $('#workDtlCancel').hide();
            $('.deleteButton.work').hide();
            $('.editItemButton.work').hide();
            clearWorkForm();
            $('#cancelEditWork').hide();
            $('#editDtlWork').show();
        });

        $('#trainDtlCancel').click(function(){
            $('#addTrain').hide();
            $('#editDtlTrain').show();
            $('#trainDtlSave').hide();
            $('#trainDtlCancel').hide();
            $('.deleteButton.train').hide();
            $('.editItemButton.train').hide();
            clearTrainingForm();
            $('#cancelEditTrain').hide();
            $('#editDtlTrain').show();
        });

        // Cancel di samping Add New (Train)
        $('#cancelEditTrain').click(function(){
            $('#addTrain').hide();
            $('#editDtlTrain').show();
            $('#trainDtlSave').hide();
            $('#trainDtlCancel').hide();
            $('.deleteButton.train').hide();
            $('.editItemButton.train').hide();
            clearTrainingForm();
            $('#cancelEditTrain').hide();
            $('#editDtlTrain').show();
        });
        
        function clearEducationForm() {
            $('#education_id').val('0');
            $('#institute').val('');
            $('#major').val('');
            $('#year').val('');
            $('#score').val('');
            $('#start_date').val('');
            $('#end_date').val('');
        }

        function clearWorkForm() {
            $('#eexp_employer').val('');
            $('#eexp_jobtit').val('');
            $('#eexp_from_date').val('');
            $('#eexp_to_date').val('');
            $('#eexp_comments').val('');
        }

        function clearTrainingForm() {
            $('#train_name').val('');
            $('#license_no').val('');
            $('#license_issued_date').val('');
            $('#license_expiry_date').val('');
        }

        function formatDate(date) {
            if (!date) return '';
            return date.split(' ')[0];
        }
    });
</script>
<div class="table-responsive">
    <div>
        <form id="addEdu" action="{{ route('personalEmp.setEducation') }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <input type="hidden" name="idEduEmp" id="idEduEmp" />
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <?php $edu = \App\Models\Master\Education::lists('name','id')->prepend('-=Pilih=-', '0'); ?>
                    <label for="education_id">Level <span style="color: red;">*</span></label>
                    {!! Form::select('education_id', $edu, null, ['class' => 'form-control', 'id' => 'education_id']) !!}
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="institute">Institute <span style="color: red;">*</span></label>
                    <input class="form-control" type="text" name="institute" id="institute" />
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                <div class="form-group">
                    <label for="major">Major/Specialization <span style="color: red;">*</span></label>
                    <input class="form-control" type="text" name="major" id="major" />
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                <div class="form-group">
                    <label for="year">Year</label>
                    <input class="form-control" type="text" name="year" id="year" />
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                <div class="form-group">
                    <label for="score">GPA/Score</label>
                    <input class="form-control" type="text" name="score" id="score" />
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="start_date">Start Date <span style="color: red;">*</span></label>
                    <input class="form-control" type="text" name="start_date" id="start_date" readonly="readonly" />
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="end_date">End Date <span style="color: red;">*</span></label>
                    <input class="form-control" type="text" name="end_date" id="end_date" readonly="readonly" />
                </div>
            </div>
            <input type="submit" class="btn btn-primary" id="eduDtlSave" value="Save">
            <input type="button" class="btn btn-danger" id="eduDtlCancel" value="Cancel" style="display:none;">
        </form>
        <h4>Education</h4>
        <button id="addNewEdu" class="btn btn-primary">Add New</button>
<button id="cancelEditEdu" class="btn btn-danger" style="display:none; margin-left:8px;">Cancel</button>
<button id="editDtlEdu" class="btn btn-success">Edit</button>
        <table id="data-table-basic" class="table table-striped">
            <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Institution Name</th>
                <th>Major</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                @if($edus)
                    <?php $no = 1;?>
                    @foreach($edus as $row)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $row->education->name }}</td>
                            <td>{{ $row->institute }}</td>
                            <td>{{ $row->major }}</td>
                            <td>{{ $row->start_date == "Jan  1 1900 12:00:00:AM" ? "-" : date_formated($row->start_date)  }}</td>
                            <td>{{ $row->end_date == "Jan  1 1900 12:00:00:AM" ? "-" : date_formated($row->end_date)  }}</td>
                            <td>
                                <a class="editItemButton edu" href="#" data-id="{{ $row->id }}" 
                                   data-education="{{ $row->education_id }}"
                                   data-institute="{{ $row->institute }}"
                                   data-major="{{ $row->major }}"
                                   data-year="{{ $row->year }}"
                                   data-score="{{ $row->score }}"
                                   data-start="{{ $row->start_date }}"
                                   data-end="{{ $row->end_date }}">
                                    <i class="fa fa-edit" title="Edit"></i>
                                </a>
                                <a href="#" class="deleteButton edu" data-url="{{ route('personalEmp.deleteEducation', $row->id) }}">
                                    <i class="fa fa-trash" title="Delete"></i>
                                </a>
                            </td>
                            <?php $no++;?>
                        </tr>
                    @endforeach
                @else
                    <tr><td colspan="7">No Data</td></tr>
                @endif
            </tbody>
        </table>
    </div>
<fieldset>
    <form id="addWork" action="{{ route('personalEmp.setWork') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <input type="hidden" name="idWorkEmp" id="idWorkEmp" />
        <div class="form-group">
            <label for="eexp_employer">Company <span style="color: red;">*</span></label>
            <input class="form-control" type="text" name="eexp_employer" id="eexp_employer" />
        </div>
        <div class="form-group">
            <label for="eexp_jobtit">Job Title <span style="color: red;">*</span></label>
            <input class="form-control" type="text" name="eexp_jobtit" id="eexp_jobtit" />
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="eexp_from_date">From <span style="color: red;">*</span></label>
                <input class="form-control" type="text" name="eexp_from_date" id="eexp_from_date" readonly="readonly" />
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="eexp_to_date">To <span style="color: red;">*</span></label>
                <input class="form-control" type="text" name="eexp_to_date" id="eexp_to_date" readonly="readonly" />
            </div>
        </div>
        <div class="form-group">
            <label for="eexp_comments">Comment</label>
            <textarea rows="6" class="form-control" type="text" name="eexp_comments" id="eexp_comments"></textarea>
        </div>
        <input type="submit" class="btn btn-primary" id="workDtlSave" value="Save">
        <input type="button" class="btn btn-danger" id="workDtlCancel" value="Cancel" style="display:none;">
    </form>
    <div>
        <h4>Work Experience</h4>
        <button id="addNewWork" class="btn btn-primary">Add New</button>
<button id="cancelEditWork" class="btn btn-danger" style="display:none; margin-left:8px;">Cancel</button>
<button id="editDtlWork" class="btn btn-success">Edit</button>
        <table id="data-table-basic" class="table table-striped">
            <thead>
            <tr>
                <th>No</th>
                <th>Company Name</th>
                <th>Job Level</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                @if($quali)
                    <?php $no = 1;?>
                    @foreach($quali as $row)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $row->eexp_employer }}</td>
                            <td>{{ $row->eexp_jobtit }}</td>
                            <td>{{ date_formated($row->eexp_from_date) }}</td>
                            <td>{{ date_formated($row->eexp_to_date) }}</td>
                            <td>
                                <a class="editItemButton work" href="#" data-id="{{ $row->id }}"
                                   data-employer="{{ $row->eexp_employer }}"
                                   data-jobtitle="{{ $row->eexp_jobtit }}"
                                   data-fromdate="{{ $row->eexp_from_date }}"
                                   data-todate="{{ $row->eexp_to_date }}"
                                   data-comments="{{ $row->eexp_comments }}">
                                    <i class="fa fa-edit" title="Edit"></i>
                                </a>
                                <a href="#" class="deleteButton work" data-url="{{ route('personalEmp.deleteWork', $row->id) }}">
                                    <i class="fa fa-trash" title="Delete"></i>
                                </a>
                            </td>
                        </tr>
                        <?php $no++;?>
                    @endforeach
                @else
                    <tr><td colspan="6">No Data</td></tr>
                @endif
            </tbody>
        </table>
    </div>
</fieldset>
    <fieldset>
        <form id="addTrain" action="{{ route('personalEmp.setTrain') }}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <input type="hidden" name="idTrainEmp" id="idTrainEmp" />
            <div class="form-group">
                <label for="train_name">Training Name</label>
                <input class="form-control" type="text" name="train_name" id="train_name" />
            </div>
            <div class="form-group">
                <label for="license_no">Sertificate No</label>
                <input class="form-control" type="text" name="license_no" id="license_no" />
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="license_issued_date">Start Training Date</label>
                    <input class="form-control" type="text" name="license_issued_date" id="license_issued_date" readonly="readonly" />
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="license_expiry_date">End Training Date</label>
                    <input class="form-control" type="text" name="license_expiry_date" id="license_expiry_date" readonly="readonly" />
                </div>
            </div>
            <input type="submit" class="btn btn-primary" id="trainDtlSave" value="Save">
            <input type="button" class="btn btn-danger" id="trainDtlCancel" value="Cancel" style="display:none;">
        </form>
        <div>
            <h4>Training</h4>
            <button id="addNewTrain" class="btn btn-primary">Add New</button>
<button id="cancelEditTrain" class="btn btn-danger" style="display:none; margin-left:8px;">Cancel</button>
<button id="editDtlTrain" class="btn btn-success">Edit</button>
            <table id="data-table-basic" class="table table-striped">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Training Name</th>
                    <th>Sertificate No</th>
                    <th>Start Training Date</th>
                    <th>End Training Date</th>
                </tr>
                </thead>
                <tbody>
                @if($trains)
                    <?php $no = 1;?>
                    @foreach($trains as $row)
                        <tr>
                            <td>{{ $no }}</td>
                            @if($row->license_id)
                                <td>@if($row->license_id == 1) {{ $row->train_name }} @else {{ $row->trainning->name }} @endif</td>
                            @else
                                <td>{{ $row->train_name }}</td>
                            @endif
                            <td>{{ $row->license_no }}</td>
                            <td>{{ date_formated($row->license_issued_date) }}</td>
                            <td>{{ date_formated($row->license_expiry_date) }}</td>
                            <td>
                                <a class="editItemButton train" href="#" data-id="{{ $row->id }}"
                                   data-name="{{ $row->train_name }}"
                                   data-licenseno="{{ $row->license_no }}"
                                   data-issueddate="{{ $row->license_issued_date }}"
                                   data-expirydate="{{ $row->license_expiry_date }}">
                                    <i class="fa fa-edit" title="Edit"></i>
                                </a>
                                <a href="#" class="deleteButton train" data-url="{{ route('personalEmp.deleteTrain', $row->id) }}">
                                    <i class="fa fa-trash" title="Delete"></i>
                                </a>
                            </td>
                        </tr>
                        <?php $no++;?>
                    @endforeach
                @else
                    <tr><td colspan="6">No Data</td></tr>
                @endif
                </tbody>
            </table>
        </div>
    </fieldset>
</div>
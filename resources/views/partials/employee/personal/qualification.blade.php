<script type="text/javascript">
    $(document).ready(function() {
        $('#addEdu').hide();
        $('#addWork').hide();
        $('#addTrain').hide();
        $('#eduDtlSave').hide();
        $('#eduDtlCancel').hide();
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

        // Add click handler for edit button
        $(document).on("click", ".edit-education", function() {
            var id = $(this).data('id');
            $('#addEdu').show();
            $('#editDtlEdu').hide();
            
            // Get education data
            $.ajax({
                url: '{{ route('personal.getEducation') }}',
                type: 'get',
                data: {id: id},
                dataType: 'json',
                success: function(data) {
                    $('#education_id').val(data.education_id);
                    $('#institute').val(data.institute);
                    $('#major').val(data.major);
                    $('#year').val(data.year);
                    $('#score').val(data.score);
                    $('#start_date').val(data.start_date);
                    $('#end_date').val(data.end_date);
                    $('#edu_id').val(data.id);
                    
                    // Change form action to update
                    $('#addEdu').attr('action', '{{ route('personal.updateEducation') }}');
                }
            });
        });

        $('#editDtlEdu').click(function(){
            $('#addEdu').show();
            $('#editDtlEdu').hide();
            $('#eduDtlSave').show();
            $('#eduDtlCancel').show();
            
            // Reset form for adding new data
            $('#addEdu')[0].reset();
            $('#edu_id').val('');
            $('#addEdu').attr('action', '{{ route('personal.setEducation') }}');
        });

        $('#eduDtlCancel').click(function(){
            $('#addEdu').hide();
            $('#editDtlEdu').show();
            $('#eduDtlSave').hide();
            $('#eduDtlCancel').hide();
        });

        $('#eduDtlSave').click(function (){
            $('form#addEdu').submit();
        });

        $('#editDtlWork').click(function(){
            $('#addWork').show();
            $('#editDtlWork').hide();
            $('#workDtlSave').show();
            $('#workDtlCancel').show();
        });
        $('#workDtlCancel').click(function(){
            $('#addWork').hide();
            $('#editDtlWork').show();
            $('#workDtlSave').hide();
            $('#workDtlCancel').hide();
        });
        $('#workDtlSave').click(function (){
            $('form#addWork').submit();
        });

        $('#editDtlTrain').click(function(){
            $('#addTrain').show();
            $('#editDtlTrain').hide();
            $('#workDtlSave').show();
            $('#workDtlCancel').show();
        });
        $('#trainDtlCancel').click(function(){
            $('#addTrain').hide();
            $('#editDtlTrain').show();
            $('#trainDtlSave').hide();
            $('#trainDtlCancel').hide();
        });
        $('#trainDtlSave').click(function (){
            $('form#addTrain').submit();
        });
        $('#license_issued_date').datetimepicker({
            format: 'Y-m-d',
        });
        $('#license_expiry_date').datetimepicker({
            format: 'Y-m-d',
        });
    });
    function deleteConfirmation(e, message) {
        if (!confirm("Delete " + message + "?")) {
            e.preventDefault();
        }
    }
</script>
<div class="table-responsive">
    <?php
    function date_formated($date){
        $new_date = date('d-m-Y', strtotime(substr($date, 0, 11)));
        return $new_date;
    }
    ?>
    <div>
        <form id="addEdu" action="{{ route('personal.setEducation') }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <input type="hidden" name="id" id="edu_id" />
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
                    <input class="form-control" type="text" name="institute" id="institute"/>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                <div class="form-group">
                    <label for="major">Major/Specialization <span style="color: red;">*</span></label>
                    <input class="form-control" type="text" name="major" id="major"/>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                <div class="form-group">
                    <label for="year">Year</label>
                    <input class="form-control" type="number" name="year" id="year" />
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
            <input type="submit" class="btn btn-primary" value="Save">
            <input type="reset" class="btn btn-danger" id="eduDtlCancel" value="Cancel">
        </form>
        <h4>Education</h4>
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
                        <td><?php echo date_formated($row->start_date); ?></td>
                        <td><?php echo date_formated($row->end_date); ?></td>
                        <td>
                            <a href="#" class="edit-education" data-id="{{ $row->id }}"><i class="fa fa-edit" title="Edit"></i></a>
                            <a onclick="deleteConfirmation(event,'education')" id="deleteButton" class="deleteButton" href="{{ route('personal.deleteEducation', $row->id) }}"><i class="fa fa-trash" title="Delete"></i></a>
                        </td>
                        <?php $no++;?>
                        </tr>
                    @endforeach
                @else
                    <tr><td colspan="5">No Data</td></tr>
                @endif
            </tbody>
        </table>
        <button id="editDtlEdu" class="btn btn-success">Add New</button>
    </div>
    <div style="margin-top: 25px;"></div>
<fieldset>
    <form id="addWork" action="{{ route('personal.setWork') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
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
        <input type="reset" class="btn btn-danger" id="workDtlCancel" value="Cancel">
    </form>
    <div>
        <h4>Work Experience</h4>
        <table id="data-table-basic" class="table table-striped">
            <thead>
            <tr>
                <th>No</th>
                <th>Company Name</th>
                <th>Job Level</th>
                <th>Start Date</th>
                <th>End Date</th>
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
                        <td><?php echo date_formated($row->eexp_from_date); ?></td>
                        <td><?php echo date_formated($row->eexp_to_date); ?></td>
                        <td><a onclick="deleteConfirmation(event,'work')" id="deleteButton" class="deleteButton" href="{{ route('personal.deleteWork', $row->id) }}"><i class="fa fa-trash" title="Delete"></i></a></td>
                    </tr>
                        <?php $no++;?>
                    @endforeach
                @else
                    <td colspan="5">No Data</td>
                @endif
            </tbody>
        </table>
        <button id="editDtlWork" class="btn btn-success">Edit</button>
    </div>
</fieldset>
    <div style="margin-top: 25px;"></div>
<fieldset>
    <form id="addTrain" action="{{ route('personal.setTrain') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
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
                <label for="license_issued_date">Sertificate Date</label>
                <input class="form-control" type="text" name="license_issued_date" id="license_issued_date" readonly="readonly" />
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="license_expiry_date">Expired Date</label>
                <input class="form-control" type="text" name="license_expiry_date" id="license_expiry_date" readonly="readonly" />
            </div>
        </div>
        <input type="submit" class="btn btn-primary" id="trainDtlSave" value="Save">
        <input type="reset" class="btn btn-danger" id="trainDtlCancel" value="Cancel">
    </form>
    <div>
        <h4>Training</h4>
        <table id="data-table-basic" class="table table-striped">
            <thead>
            <tr>
                <th>No</th>
                <th>Training Name</th>
                <th>Sertificate No</th>
                <th>Sertificate Date</th>
                <th>Expired Date</th>
            </tr>
            </thead>
            <tbody>
            @if($trains)
                <?php $no = 1;?>
                @foreach($trains as $row)
                    <tr>
                        <td>{{ $no }}</td>
                        <td>@if($row->license_id == 1) {{ $row->train_name }} @else {{ $row->trainning->name }} @endif</td>
                        <td>{{ $row->license_no }}</td>
                        <td><?php echo date_formated($row->license_issued_date); ?></td>
                        <td><?php echo date_formated($row->license_expiry_date); ?></td>
                    </tr>
                    <?php $no++;?>
                @endforeach
            @else
                <td colspan="5">No Data</td>
            @endif
            </tbody>
        </table>
<!--        <button id="editDtlTrain" class="btn btn-success">Edit</button>-->
    </div>
</fieldset>
</div>
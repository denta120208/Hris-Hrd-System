@extends('_main_layout')

@section('content')
<style>
    .toolbar {
        float:left;
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on("click", ".open-reqModal", function () {
            var id = $(this).data('id');
            $(".modal-body #id").val(id);
            if(id > 0){
                $.ajax({
                    url: '{{ route('recruitment.getReqVacan') }}',
                    type: 'get',
                    data: {id:id},
                    dataType: 'json',
                    success:function(data){
                        $('#name').val(data['name']);
                        $('#job_title_code').val(data['job_title_code']);
                        $('#dept_id').val(data['dept_id']);
                        $('#location_id').val(data['location_id']);
                        $('#no_of_positions').val(data['no_of_positions']);
                        $('#description').val(data['description']);
                    }
                });
            }else{
                $('#name').val('');
                $('#job_title_code').val('0');
                $('#dept_id').val('0');
                $('#location_id').val('0');
                $('#no_of_positions').val('');
                $('#description').val('');
            }
        });
        $('#reqTable').DataTable({
            dom: 'l<"toolbar">frtip',
            initComplete: function(){
                $("div.toolbar")
                    .html('<a class="btn btn-primary open-reqModal" id="editAtt" href="#reqModal" data-toggle="modal"><i class="fa fa-plus"></i> New Request</a>');
            }
        });
    });
</script>
<div class="container">
    <div style="margin-bottom: 20px;"></div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <form action="{{ route('recruitment.search') }}" method="post" class ="form-inline">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="form-group">
                    <label for="emp_name" class="sr-only">Name</label>
                    <input class="form-control" type="text" name="emp_name" id="emp_name" placeholder="Name" />
                </div>
                <div class="form-group">
                    <label for="employee_id" class="sr-only">NIK</label>
                    <input class="form-control" type="text" name="employee_id" id="employee_id" placeholder="NIK" />
                </div>
                <div class="form-group">
                    <?php
                    $emp_status = \App\Models\Master\EmploymentStatus::lists('name','id')->prepend('Employment Status', '0');
                    ?>
                    {!! Form::label('emp_status', 'Employment Status', ['class'=>'sr-only']) !!}
                    {!! Form::select('emp_status', $emp_status, '', ['class' => 'form-control', 'id' => 'emp_status']) !!}
                </div>
                <div class="form-group">
                    <?php
                    $jobCategory = \App\Models\Employee\JobCategory::lists('name','id')->prepend('Divisi', '0');
                    ?>
                    {!! Form::label('eeo_cat_code', 'Divisi', ['class'=>'sr-only']) !!}
                    {!! Form::select('eeo_cat_code', $jobCategory, '', ['class' => 'form-control eeo_cat_code', 'id' => 'eeo_cat_code']) !!}
                </div>
                <div class="form-group">
                    <label for="termination_id" class="sr-only">Employee Status</label>
                    <select name="termination_id" class="form-control" id="termination_id">
                        <option value="" disabled selected>Employee Status</option>
                        <option value="1">Active</option>
                        <option value="2">Past</option>
                    </select>
                </div>
                <button class="btn btn-success">Search</button>
            </form>
        </div>
        <div style="margin-bottom: 60px;"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?php $no = 1;?>
            <table id="reqTable" class="table table-responsive table-striped">
                <thead>
                <tr>
                    <th>Nos</th>
                    <th>Job Title</th>
                    <th>Job Level</th>
                    <th>Location</th>
                    <th>No of Position</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($vacans as $vacan)
                    <tr>
                        <td>{{ $no }}</td>
                        <td>{{ $vacan->name }}</td>
                        <td>{{ $vacan->job_title->job_title }}</td>
                        <td>{{ $vacan->job_location->name }}</td>
                        <td>{{ $vacan->no_of_positions }}</td>
                        @if($vacan->vacancy_status > '1')
                        <td><a id="show" href="{{ route('hrd.vPersonal',$vacan->id) }}" ><i class="fa fa-eye"></i></a></td>
                        @else
                        <td><a id="editAtt" href="#reqModal" data-toggle="modal" class="open-reqModal" data-id="{{ $vacan->id }}"><i class="fa fa-edit"></i></a></td>
                        @endif
                    </tr>
                    <?php $no++;?>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="reqModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="reqModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                <h4 class="modal-title" id="reqModal">Request Vacancy</h4>
            </div>
            <form action="{{ route('recruitment.setReqVacan') }}" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="id" id="id" />
                    <div class="form-group">
                        <label for="name">Job Title</label>
                        <input class="form-control" type="text" name="name" id="name" />
                    </div>
                    <div class="form-group">
                        <?php
                        $job_title_code = \App\Models\Master\JobMaster::lists('job_title','id')->prepend('Job Level', '0');
                        ?>
                        {!! Form::label('job_title_code', 'Job Level') !!}
                        {!! Form::select('job_title_code', $job_title_code, '', ['class' => 'form-control job_title_code', 'id' => 'job_title_code']) !!}
                    </div>
                    <div class="form-group">
                        <?php
                        $dept_id = \App\Models\Employee\JobCategory::lists('name','id')->prepend('Divisi', '0');
                        ?>
                        {!! Form::label('dept_id', 'Divisi') !!}
                        {!! Form::select('dept_id', $dept_id, '', ['class' => 'form-control dept_id', 'id' => 'dept_id']) !!}
                    </div>
                    <div class="form-group">
                        <?php
                        $loc_id = \App\Models\Master\Location::lists('name','id')->prepend('Location', '0');
                        ?>
                        {!! Form::label('location_id', 'Location') !!}
                        {!! Form::select('location_id', $loc_id, '', ['class' => 'form-control location_id', 'id' => 'location_id']) !!}
                    </div>
                    <div class="form-group">
                        <label for="no_of_positions">No of Position</label>
                        <input class="form-control" type="number" name="no_of_positions" id="no_of_positions" />
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" rows="5" name="description" id="description"></textarea>
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
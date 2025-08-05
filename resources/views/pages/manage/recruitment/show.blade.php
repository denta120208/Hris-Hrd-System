@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on("click", ".open-reqModal", function () {
            var id = $(this).data('id');
            $(".modal-body #id").val(id);
        });
        $('#vTable').DataTable({
            dom: 'l<"toolbar">frtip',
            // initComplete: function(){
            //     $("div.toolbar")
            //         .html('');
            // }
        });
        // var table = $('#vTable').DataTable();
    });
</script>
<div class="container">
    <div class="row">
        <div class="contact-area">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1>Job Vacancy {{ $jobVacan->name }}</h1>
                <h4>Job Level {{ $jobVacan->job_title->job_title }}</h4>
                <h4>Location {{ $jobVacan->job_location->name }}</h4>
                <h4>No Positions {{ $jobVacan->no_of_positions }}</h4>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <a class="btn btn-danger open-reqModal"><i class="fa fa-hand-stop-o"></i> Close Vacancy</a>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php $no = 1;?>
                <table id="vTable" class="table table-responsive table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>email</th>
                        <th>Contact Number</th>
                        <th>Apply Date</th>
                        <th>Status</th>
                        <th>Detail</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($jobCandidate as $row)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $row->job_candidate->first_name." ".$row->job_candidate->middle_name." ".$row->job_candidate->last_name }}</td>
                            <td>{{ $row->job_candidate->email }}</td>
                            <td>{{ $row->job_candidate->contact_number }}</td>
                            <td>{{ $row->applied_date }}</td>
                            <td>{{ $row->job_candidate->contact_number }}</td>
                            <td><a  id="viewCan" href="#viewCandidate" data-toggle="modal" class="open-viewCandidate" data-id="{{ $row->job_candidate->id }}"><i class="fa fa-eye"></i></a></td>
                            <td><a  href="#"><i class="fa fa-check-circle"></i></a></td>
                        </tr>
                        <?php $no++;?>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="viewCandidate" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="reqModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                <h4 class="modal-title" id="viewCandidate">Request Vacancy</h4>
            </div>
            <form action="{{ route('hrd.recruitment') }}" method="POST">
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
                        <textarea name="description" id="description"></textarea>
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
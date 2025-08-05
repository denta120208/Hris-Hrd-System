@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        $('#empTable').DataTable({});

    });
</script>
<div class="container">
    <h2>Education Search Report</h2>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <form action="{{ route('hrd.srEducation') }}" method="post" class ="form-inline">
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
                    $emp_edu = \App\Models\Master\Education::lists('name', 'id')->prepend('Education', '0');
                    ?>
                    {!! Form::label('education_id', 'Education', ['class'=>'sr-only']) !!}
                    {!! Form::select('education_id', $emp_edu, '', ['class' => 'form-control', 'id' => 'education_id']) !!}
                </div>
                <div class="form-group">
                    <label for="institute" class="sr-only">Institute</label>
                    <input class="form-control" type="text" name="institute" id="institute" placeholder="Univ. Trisakti" />
                </div>
                <div class="form-group">
                    <label for="major" class="sr-only">Major</label>
                    <input class="form-control" type="text" name="major" id="major" placeholder="Ekonomi" />
                </div>
                <button class="btn btn-success">Search</button>
            </form>
        </div>
        <div style="margin-bottom: 60px;"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="data-table-list">
                <div class="table-responsive">
                    <?php $no = 1; ?>
                    <table id="empTable" class="table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIK</th>
                                <th>Name</th>
                                <th>Education</th>
                                <th>Institute</th>
                                <th>Major</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($emps as $emp)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $emp->employee_id }}</td>
                                <td>{{ $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname }}</td>
                                <td>{{ $emp->name }}</td>
                                <td>{{ $emp->institute }}</td>
                                <td>{{ $emp->major }}</td>
                            </tr>
                            <?php $no++; ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
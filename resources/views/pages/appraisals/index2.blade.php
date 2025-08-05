@extends('_main_layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table id="data-table-basic" class="table table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Name</th>
                        <th>Appraisal Type</th>
                        <th>Emp Appraisal</th>
                        <th>Sup Appraisal</th>
                        <th>Dir Appraisal</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($emps)
                        <?php $no = 1;?>
                        @foreach($emps as $row)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $row->employee_id }}</td>
                                <td>{{ $row->emp_firstname." ".$row->emp_middle_name." ".$row->emp_lastname }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->emp_value  }}</td>
                                <td>{{ $row->sup_value  }}</td>
                                <td>{{ $row->dir_value  }}</td>
                                <td>
                                    <a href="{{ route('hrd.appraisal.view', $row->emp_number) }}"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                        <?php $no++;?>
                        @endforeach
                    @else
                        <tr><td>No Entitlement</td></tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
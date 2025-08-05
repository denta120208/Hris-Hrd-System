@extends('_main_layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table id="data-table-basic" class="table table-striped">
                    <thead>
                    <tr>
                        <th>NIK</th>
                        <th>Name</th>
                        <th>Job Level</th>
                        <th>Value Appraisal</th>
                        <th>Alpha Appraisal</th>
                        <th>9 Box Category</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($emps)
                        <?php $no = 1;?>
                        @foreach($emps as $row)
                            <?php $alph = \App\Models\Appraisal\AprraisalResult::where('min_val', '<=', $row->sup_value)->where('max_val', '>=', $row->sup_value)->first(); ?>
                            <tr>
                                <td>{{ $row->employee_id }}</td>
                                <td>{{ $row->emp_name }}</td>
                                <td>{{ $row->job_title->job_title }}</td>
                                <td>{{ $row->sup_value }}</td>
                                <td>{{ $alph->alpha_val }}</td>
                                <td>{{ $row->sup_box_9 }}</td>
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
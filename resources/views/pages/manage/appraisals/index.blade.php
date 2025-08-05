@extends('_main_layout')

@section('content')
<div class="container">
    <h2>Appraisal</h2>
    @if(Session::get('project') == 'HO')
    <div class="row">
        <form method="post" action="{{ route('hrd.setYearAppraisal') }}">
             {{ csrf_field() }}
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="active_year">Active Year</label>
                    <select name="active_year" id="active_year" class="form-control">
                        @for ($i=2024;$i<=2034;$i++)
                            @if($i == $year)
                                <option value="{{$i}}" selected>{{$i}}</option>
                            @else
                                <option value="{{$i}}">{{$i}}</option>
                            @endif
                        @endfor    
                    </select>
                </div>
            </div>
            <div class="col-lg-2" style="margin-top: 25px; margin-right: 35px;">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
    @endif
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="data-table-list">
                <div class="table-responsive">
                    <table id="data-table-basic" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIK</th>
                                <th>Name</th>
                                <th>Year</th>
                                <th>Appraisal Form</th>
                                <th>Appraisal Type</th>
                                <th>Score</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($emps)
                            <?php $no = 1; ?>
                            @foreach($emps as $row)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $row->employee_id }}</td>
                                <td>{{ $row->emp_firstname." ".$row->emp_middle_name." ".$row->emp_lastname }}</td>
                                <td>{{ $row->period }}</td>
                                <td>{{ $row->code_appraisal }}</td>
                                <td>{{ $row->evaluator_status }}</td>
                                <td>{{ number_format($row->appraisal_value,0,',',',')  }}</td>
                                <td>
                                    <a href="{{ route('hrd.appraisal.view', $row->emp_number) }}"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                            <?php $no++; ?>
                            @endforeach
                            @else
                            
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function(){
        $('#leave').addClass("active");
        $('#mailbox').addClass("in active");
    });
</script>
    <div class="container">
        <input type="hidden" id="addClasses" value="active" />
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="data-table-list">
                    <div class="table-responsive">
                        <h2>Balance Leave</h2>
                        <table id="data-table-basic" class="table table-striped">
                            <thead>
                            <tr>
                                <th>Subordinate</th>
                                <th>Leave Type</th>
                                <th>Valid From</th>
                                <th>Valid To</th>
                                <th>Days</th>
                                <th>Taken</th>
                                <th>Balance</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($leaves)
                                @foreach($leaves as $row)
                            <tr>
                                <td>{{ $row->emp_firstname.' '.$row->emp_middle_name.' '.$row->emp_lastname }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ date('d-m-Y', strtotime($row->from_date)) }}</td>
                                <td>{{ date('d-m-Y', strtotime($row->to_date)) }}</td>
                                <td>{{ $row->no_of_days }}</td>
                                <td>{{ $row->days_used }}</td>
                                <td>{{ $row->no_of_days - $row->days_used }}</td>
                            </tr>
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
    </div>
@endsection
@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        $('#otTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'excel', 'pdf', 'print'
            ]
        });
        $('#date_filter').datetimepicker({
            format: 'Y-m-d',
        });
    });
</script>
<div class="container">
    <div class="row">
        <h1>Overtime</h1>
        {{--        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">--}}
        {{--            <a href="{{ route('overtimeRequest.add') }}" class="btn btn-primary">New Request</a>--}}
        {{--        </div>--}}
        <div style="margin-bottom: 60px;"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="data-table-list">
                <div class="table-responsive">
                    <?php $no = 1; ?>
                    <table id="otTable" class="table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>Emp Name</th>
                                <th>Date</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Status</th>
                                <th>Requested At</th>
                                <th>Approved By</th>
                                <th>Approved At</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($ots)
                            @foreach($ots as $row)
                            <tr>
                                <td>{{ $row->emp_name->emp_firstname." ".$row->emp_name->emp_lastname }}</td>
                                <td>{{ $row->ot_date }}</td>
                                <td>{{ date("H:i:s", strtotime($row->ot_start_time)) }}</td>
                                <td>{{ date("H:i:s", strtotime($row->ot_end_time)) }}</td>
                                <td>{{ $row->overtime_status->name }}</td>
                                <td>{{ date("Y-m-d H:i:s", strtotime($row->created_at)) }}</td>
                                @if($row->emp_id_name)
                                <td>{{ $row->emp_id_name->emp_firstname." ".$row->emp_id_name->emp_lastname }}</td>
                                @else
                                <td>-</td>
                                @endif
                                @if($row->approved_at)
                                <td>{{ date("Y-m-d H:i:s", strtotime($row->approved_at)) }}</td>
                                @else
                                <td>-</td>
                                @endif
                                <td></td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td></td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
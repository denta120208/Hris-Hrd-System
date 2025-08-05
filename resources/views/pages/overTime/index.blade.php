@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        $('#otTable').DataTable({});
        $('#date_filter').datetimepicker({
            format: 'Y-m-d',
        });
    });
</script>

<div class="container">
    <div class="row">

        <!--        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <a href="{{ route('overtimeRequest.add') }}" class="btn btn-primary">New Request</a>
                </div>-->
        <!--<div style="margin-bottom: 60px;"></div>-->
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="data-table-list">
                <div class="table-responsive">
                    <h2>Overtime Request</h2>                    
                    <?php $no = 1; ?>
                    <table id="otTable" class="table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Overtime Hours</th>
                                <th>Overtime Total Hours</th>
                                <th>Overtime Meal Number</th>
                                <th>Reason</th>
                                <th>Status</th>
            <!--                    <th>Requested At</th>
                                <th>Approved By</th>
                                <th>Approved At</th>-->
                                <!--<th></th>-->
                            </tr>
                        </thead>
                        <tbody>
                            @if($requests)
                            @foreach($requests as $row)
                            <tr>
                                <td>{{ date('d-m-Y', strtotime(substr($row->ot_date, 0, 11))) }}</td>
                                <td>{{ date('H:i:s', strtotime($row->ot_start_time)) }}</td>
                                <td>{{ date('H:i:s', strtotime($row->ot_end_time)) }}</td>
                                <td>{{ $row->ot_hours }}</td>
                                <td>{{ $row->ot_total_hours }}</td>
                                <td>{{ $row->ot_meal_num }}</td>
                                <td>{{ $row->ot_reason }}</td>
                                <td>{{ $row->overtime_status->name }}</td>
            <!--                    <td>{{ date('d-m-Y', strtotime($row->created_at)) }}</td>
                                <td>{{ $row->approved_by }}</td>
                                <td>{{ date('d-m-Y', strtotime($row->approved_at)) }}</td>-->
                                <!--<td></td>-->
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
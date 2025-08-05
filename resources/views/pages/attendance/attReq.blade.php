@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        $('#otTable').DataTable({
            order: [[0, 'desc']]
        });
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
                    <h2>Attendance Request</h2>                    
                    <?php $no = 1; ?>
                    <table id="otTable" class="table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>Time In</th>
                                <th>Time Out</th>
                                <th>Information</th>
                                <th>Reason</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($attR)
                            @foreach($attR as $row)
                            <tr>
                                @if($row->start_date1 != "01-01-1900 00:00:00")
                                <td>{{ date('d-m-Y', strtotime(substr($row->start_date1, 0, 11))) }}</td>
                                @else
                                <td></td>
                                @endif
                                @if($row->end_date1 != "01-01-1900 00:00:00")
                                <td>{{ date('d-m-Y', strtotime(substr($row->end_date1, 0, 11))) }}</td>
                                @else
                                <td></td>
                                @endif
                                <td>{{ $row->keterangan }}</td>
                                <td>{{ $row->reason }}</td>
                                <td>{{ $row->status_name }}</td>
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
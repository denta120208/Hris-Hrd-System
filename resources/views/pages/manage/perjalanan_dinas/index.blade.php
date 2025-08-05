@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        $('#pdTable').DataTable({});
        $('#date_filter').datetimepicker({
            format: 'Y-m-d',
        });
    });
</script>
<div class="container">
    <h2>Perjalanan Dinas</h2>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <a href="{{ route('hrd.perjalanDinasRequest.add') }}" class="btn btn-primary">New Request</a>
        </div>
        <div style="margin-bottom: 60px;"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="data-table-list">
                <div class="table-responsive">
                    <?php $no = 1; ?>
                    <table id="pdTable" class="table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>Emp Name</th>
                                <th>Date Time</th>
                                <th>Date Time</th>
                                <th>Status</th>
                                <th>Requested At</th>
                                <th>Approved By</th>
                                <th>Approved At</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($requests)
                            @foreach($requests as $row)
                            <tr>
                                <td>{{ $row->emp_name->emp_firstname." ".$row->emp_name->emp_lastname }}</td>
                                <td>{{ $row->pd_start_date }}</td>
                                <td>{{ $row->pd_end_date }}</td>
                                <td>{{ $row->pdStatus->name }}</td>
                                <td>{{  date("Y-m-d H:i:s", strtotime($row->created_at)) }}</td>
                                @if($row->approved_at)
                                <td>{{ $row->emp_id_name->emp_firstname." ".$row->emp_id_name->emp_lastname }}</td>
                                <td>{{  date("Y-m-d H:i:s", strtotime($row->approved_at)) }}</td>
                                @else
                                <td>-</td>
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
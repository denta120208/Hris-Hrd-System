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
    <div class="row">

        <!--<div style="margin-bottom: 60px;"></div>-->
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="data-table-list">
                <div class="table-responsive">
                    <h2>Perjalanan Dinas Request</h2> 
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 10px;">
                        <a href="{{ route('perjalanDinasRequest.add') }}" class="btn btn-primary">New Request</a>
                    </div>
                    <?php $no = 1; ?>
                    <table id="pdTable" class="table table-responsive table-striped">
                        <thead>
                            <tr>
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
                                <td>{{ $row->pd_start_date }}</td>
                                <td>{{ $row->pd_end_date }}</td>
                                <td>{{ $row->pdStatus->name }}</td>
                                <td>{{ $row->created_at }}</td>
                                <td>{{ $row->approved_by }}</td>
                                <td>{{ $row->approved_at }}</td>
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
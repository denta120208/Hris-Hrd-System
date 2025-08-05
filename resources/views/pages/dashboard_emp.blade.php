@extends('_main_layout')

<style>
    .pre-scrollable-dash {
        max-height: 420px;
        overflow-y: scroll;
    }
</style>

<script type="text/javascript">
    function renderChartAge(data, labels) {
        var ctx = document.getElementById("age").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Age',
                    data: data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)'
                    ]
                }]
            },
        });
    }
    function renderChartGender(data, labels) {
        var ctx = document.getElementById("gender").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Gender',
                    data: data,
                    backgroundColor: [
                        'rgba(0,0,255, 0.7)',
                        'rgba(255,0,255, 0.7)',
                        'rgba(255,0,255, 0.3)'
                    ]
                }]
            },
        });
    }
</script>
@section('content')
    <!-- Start Status area -->
    <div class="notika-status-area">
        <div class="container">
            <div class="row">
                <h1>Welcome, <strong>{{ $emp->emp_fullname }}</strong></h1>
                <div class="table-responsive">
                    <h4>Last 7 Days Attendance</h4>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Day</th>
                            <th>Date</th>
                            <th>In Time</th>
                            <th>Out Time</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($attends)
                            @foreach($attends as $row)
                                <tr>
                                    <td>{{ date('l', strtotime($row->comDate)) }}</td>
                                    <td>{{ date('Y-m-d', strtotime($row->comDate)) }}</td>
                                    <td>{{ date('H:i:s', strtotime($row->comIn)) }}</td>
                                    <td>{{ date('H:i:s', strtotime($row->comOut)) }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td>No Data</td></tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive">
                    <h4>Available Leave</h4>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Leave Type</th>
                            <th>Entitlement Type</th>
                            <th>Valid From</th>
                            <th>Valid To</th>
                            <th>Days</th>
                            <th>Taken</th>
                            <th>Balance</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($balLeave)
                            @foreach($balLeave as $row)
                                <tr>
                                    <td>{{ $row->name }}</td>
                                    <td>-</td>
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
    <!-- End Status area-->
    <!-- Start Sale Statistic area-->
{{--    <div class="sale-statistic-area">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-lg-9 col-md-8 col-sm-7 col-xs-12">--}}
{{--                    <canvas id="age" width="400" height="230"></canvas>--}}
{{--                </div>--}}
{{--                <div class="col-lg-3 col-md-4 col-sm-5 col-xs-12">--}}
{{--                    <div class="pre-scrollable-dash statistic-right-area notika-shadow mg-tb-30 sm-res-mg-t-0">--}}
{{--                        <div class="past-day-statis">--}}
{{--                            <h2>Expire Contract</h2>--}}
{{--                        </div>--}}
{{--                        @if($contracts)--}}
{{--                            @foreach($contracts as $contract)--}}
{{--                        <div class="past-statistic-an">--}}
{{--                            <div class="past-statistic-ctn">--}}
{{--                                <h3>{{ $contract->emp_firstname." ".$contract->emp_middle_name." ".$contract->emp_lastname }}</h3>--}}
{{--                                <p>Contract End <strong>{{ date("Y-m-d", strtotime($contract->econ_extend_end_date)) }}</strong></p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                            @endforeach--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection
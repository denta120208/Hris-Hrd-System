@extends('_main_layout')

@section('content')
<script type='text/javascript'>
    $(document).ready(function(){
        $('#empTable').DataTable({
        lengthMenu: [[10, 25, 50, 100, - 1], [10, 25, 50, 100, "All"]],
                pageLength: 10,
                dom: 'Blfrtip',
                buttons: [
                {
                extend: 'excelHtml5'
                },
                {
                extend: 'pdfHtml5',
                        orientation: 'portrait',
                        pageSize: 'A4'
                },
                {
                extend: 'print'
                }
                ]
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#leave').addClass("active");
        $('#mailbox').addClass("in active");
        $('#start_date,#end_date').datetimepicker({
            useCurrent: false,
            format: 'Y-m-d',
            timepicker: false,
            // minDate: moment()
        });
        $('#start_date').datetimepicker().on('dp.change', function (e) {
            // var incrementDay = moment(new Date(e.date));
            // incrementDay.add(1, 'days');
            $('#end_date').data('DateTimePicker').minDate(incrementDay);
            $(this).data("DateTimePicker").hide();
        });
        $('#end_date').datetimepicker().on('dp.change', function (e) {
            // var decrementDay = moment(new Date(e.date));
            // decrementDay.subtract(1, 'days');
            $('#start_date').data('DateTimePicker').maxDate(decrementDay);
            $(this).data("DateTimePicker").hide();
        });
    });
</script>
<div class="container">
    <h2>Leave History</h2>
    <input type="hidden" id="addClasses" value="active" />
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <form action="{{ route('hrd.searchLeaveHistory') }}" method="post" class="form-inline">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="form-group">
                        <label for="start_date">Start Period Date</label><br>
                        <input class="form-control" type="text" name="start_date" id="start_date" autocomplete="off" readonly="yes" />
                    </div>
                    <div class="form-group">
                        <label for="end_date">End Period Date</label><br>
                        <input class="form-control" type="text" name="end_date" id="end_date" autocomplete="off" readonly="yes"/>
                    </div>
                    <div class="form-group">
                        <label for="comNIP">NIK</label><br>
                        <input class="form-control" type="text" name="comNIP" id="comNIP" placeholder="0101001" autocomplete="off"/>
                    </div>
                    <div class="form-group pull-right" style="margin-right:55px;">
                        <label style="visibility: hidden;">action</label><br>
                        <button class="btn btn-success">Search</button>
                    </div>
                </div>
            </form>
        </div>
        <div style="margin-bottom: 50px;"></div>
        <br /><br />
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="data-table-list">
                <div class="table-responsive">
                    <div>
                        <table id="empTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIK</th>
                                    <th>Employee Name</th>
                                    <th>Entitlement Type</th>
                                    <th>Date Applied</th>
                                    <th>From Date</th>
                                    <th>End Date</th>
                                    <th>Days</th>
                                    <th>Status</th>
                                    <th>Person In Charge</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @if($leaves)
                                @foreach($leaves as $leave)
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $leave->employee_id }}</td>
                                    <td>{{ $leave->emp_firstname.' '.$leave->emp_middle_name.' '.$leave->emp_lastname }}</td>
                                    <td>{{ $leave->entitlement_name }}</td>
                                    <td>{{ date("d-m-Y", strtotime($leave->date_applied)) }}</td>
                                    <td>{{ date("d-m-Y", strtotime($leave->from_date)) }}</td>
                                    <td>{{ date("d-m-Y", strtotime($leave->end_date)) }}</td>
                                    <td>{{ $leave->length_days }}</td>
                                    <td>{{ $leave->status_name }}</td>
                                    <td>{{ $leave->pic_firstname.' '.$leave->pic_middle_name.' '.$leave->pic_lastname }}</td>
                                    <td>{{ $leave->comments }}</td>
                                </tr>
                                <?php $no++; ?>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="8">No Leave History</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
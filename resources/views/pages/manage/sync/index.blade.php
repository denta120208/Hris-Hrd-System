@extends('_main_layout')

@section('content')
<script type="text/css">
    .ui-autocomplete-input {
        border: none;
        font-size: 14px;
        width: 300px;
        height: 24px;
        margin-bottom: 5px;
        padding-top: 2px;
        border: 1px solid #DDD !important;
        padding-top: 0px !important;
        z-index: 1511;
        position: relative;
    }
    .ui-menu .ui-menu-item a {
        font-size: 12px;
    }
    .ui-autocomplete {
        position: absolute;
        top: 0;
        left: 0;
        z-index: 1510 !important;
        float: left;
        display: none;
        min-width: 160px;
        width: 160px;
        padding: 4px 0;
        margin: 2px 0 0 0;
        list-style: none;
        background-color: #ffffff;
        border-color: #ccc;
        border-color: rgba(0, 0, 0, 0.2);
        border-style: solid;
        border-width: 1px;
        -webkit-border-radius: 2px;
        -moz-border-radius: 2px;
        border-radius: 2px;
        -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        -webkit-background-clip: padding-box;
        -moz-background-clip: padding;
        background-clip: padding-box;
        *border-right-width: 2px;
        *border-bottom-width: 2px;
    }
    .ui-menu-item > a.ui-corner-all {
        display: block;
        padding: 3px 15px;
        clear: both;
        font-weight: normal;
        line-height: 18px;
        color: #555555;
        white-space: nowrap;
        text-decoration: none;
    }
    .ui-state-hover, .ui-state-active {
        color: #ffffff;
        text-decoration: none;
        background-color: #0088cc;
        border-radius: 0px;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        background-image: none;
    }
    #addDtlVOC{
        width: 500px;
    }
</script>
<script type="text/javascript">
    $(document).ready(function(){
    $('#empTable').DataTable({ });
    
    $('#startDate').datetimepicker({
    useCurrent: false,
    format: 'Y-m-d',
    timepicker: false,
    });
    $('#startDate').change(function(){
      $("#endDate").datetimepicker("destroy");
      const timeElapsed = Date.now();
      $('#endDate').val('');
      var selected = Math.ceil(((new Date($('#startDate').val()).getTime()) - new Date(timeElapsed).getTime()) / (1000 * 3600 * 24));
      var selectedDate = new Date($('#startDate').val());
      var initiateDate = new Date();
      var maxDateSelect1 = new Date(initiateDate.setDate(selectedDate.getDate() + 15));
      $('#endDate').datetimepicker({
        useCurrent: false,
        format: 'Y-m-d',
        timepicker: false,
        minDate: selectedDate,
        maxDate: maxDateSelect1
      });
    });
    $('#endDate').datetimepicker({
        useCurrent: false,
        format: 'Y-m-d',
        timepicker: false,
    });
    
    $('#emp_name').autocomplete({
    source: function(request, response) {
    $.ajax({
    url: "{{ route('getEmpName') }}",
            dataType: "json",
            type: "POST",
            data: {
            emp_name: request.term,
                    _token: "{{ csrf_token() }}"
            },
            success: function(data) {
            response($.map(data, function(item) {
            var d = item.split('/');
            return {
            label: d[0] + " - " + d[1],
                    value: d[0],
                    id: d[0],
                    employee_id: d[1],
                    emp_number: d[2]
            };
            }));
            }
    });
    },
            minLength: 3,
            select: function(event, ui) {
            $('#employee_idL').val(ui.item.employee_id),
                    $('#emp_id').val(ui.item.employee_id)
            },
            open: function() {
            $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
            },
            close: function() {
            $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
            }
    });
    
    
    });
</script>
<div class="container">
    <h2>Synchronize</h2>
    <div style="margin-bottom: 50px;"></div>
    <div class="row">
        <div class="data-table-list">
            <div class="table-responsive">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form action="{{ route('hrd.syncProcess') }}" method="post" class ="form-inline">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" id="emp_id" name="emp_id" />
                        <div class="form-group">
                            {!! Form::label('leave_type_id', 'Employment Status', ['class'=>'sr-only']) !!}
                            <select name="syncType" class="form-control" id="syncType" required aria-required="true">
                                <option value="">-- Choose Type --</option>
                                <option value="1">In/Out</option>
                                <option value="2">Leave</option>
                                <option value="3">Attendance</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="employee_id" class="sr-only">Start Date</label>
                            <input type="text" class="form-control" name="startDate" id="startDate" placeholder="Start Date" required aria-required="true" autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <label for="employee_id" class="sr-only">End Date</label>
                            <input type="text" class="form-control" name="endDate" id="endDate" placeholder="End Date" required aria-required="true" autocomplete="off" />
                        </div>
                        <div class="form-group eventInsForm">
                            <label for="emp_name" class="sr-only">Full Name</label>
                            <input class="form-control" type="text" name="emp_name" id="emp_name" placeholder="Full Name" required aria-required="true"/>
                        </div>
                        <div class="form-group">
                            <label for="employee_id" class="sr-only">NIK</label>
                            <input class="form-control" type="text" name="employee_idL" id="employee_idL" disabled="disabled" placeholder="Employee Id" />
                        </div>
                        <button class="btn btn-success">Synchronize</button>
                    </form>
                </div>
                <div style="margin-bottom: 60px;"></div>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php $no = 1; ?>
                    <table id="empTable" class="table table-responsive table-striped">
                        @if($dataSync == 0)
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th>Date</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        @elseif($dataSync == 1)
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th>Date</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dataSyncTable as $row)
                            <tr>
                                <td>{{ $row->emp_id }}</td>
                                <td>{{ $row->comDate }}</td>
                                <td>{{ $row->checktime }}</td>
                            </tr>
                            <?php $no++; ?>
                            @endforeach
                        </tbody>
                        @elseif($dataSync == 2)
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th>From Date</th>
                                <th>End Date</th>
                                <th>Days</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dataSyncTable as $row)
                            <tr>
                                <td>{{ $row->employee_id }}</td>
                                <td>{{ $row->from_date }}</td>
                                <td>{{ $row->end_date }}</td>
                                <td>{{ $row->length_days }}</td>
                            </tr>
                            <?php $no++; ?>
                            @endforeach
                        </tbody>
                        @elseif($dataSync == 3)
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th>Date</th>
                                <th>Reason</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dataSyncTable as $row)
                            <tr>
                                <td>{{ $row->employee_id }}</td>
                                <td>{{ $row->start_date }}</td>
                                <td>{{ $row->reason }}</td>
                            </tr>
                            <?php $no++; ?>
                            @endforeach
                        </tbody>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
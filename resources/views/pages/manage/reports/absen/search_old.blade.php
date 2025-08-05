@extends('_main_layout')

@section('content')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#empTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel', 'pdf', 'print'
                ]
            });
            $('#start_date,#end_date').datetimepicker({
                useCurrent: false,
                format: 'Y-m-d',
                timepicker:false,
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
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <form action="{{ route('hrd.rekap_perorang') }}" method="post" class ="form-inline">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="form-group">
                        <label for="start_date" class="sr-only">Start Date</label>
                        <input class="form-control" type="text" name="start_date" id="start_date" placeholder="2020-01-16" />
                    </div>
                    <div class="form-group">
                        <label for="end_date" class="sr-only">End Date</label>
                        <input class="form-control" type="text" name="end_date" id="end_date" placeholder="2020-02-15" />
                    </div>
                    <div class="form-group">
                        <label for="comDisplayName" class="sr-only">Name</label>
                        <input class="form-control" type="text" name="comDisplayName" id="comDisplayName" placeholder="Employee Name" />
                    </div>
                    <div class="form-group">
                        <label for="comNIP" class="sr-only">NIK</label>
                        <input class="form-control" type="text" name="comNIP" id="comNIP" placeholder="0101001" />
                    </div>
                    <div class="form-group">
                        <?php
                        $project = \App\Models\Attendance\ComDept::lists('comDept','id')->prepend('-=Pilih=-', '0');
                        ?>
                        {!! Form::label('comDeptID', 'Project', ['class'=>'sr-only']) !!}
                        {!! Form::select('comDeptID', $project, '', ['class' => 'form-control', 'id' => 'comDeptID']) !!}
                    </div>
                    <button class="btn btn-success">Search</button>
                </form>
            </div>
            <div style="margin-bottom: 60px;"></div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php $no = 1;?>
                <table id="empTable" class="table table-responsive table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Name</th>
                        <th>In</th>
                        <th>Out</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($emps)
                    @foreach($emps as $emp)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $emp->comNIP }}</td>
                            <td>{{ $emp->comDisplayName }}</td>
                            <td>{{ $emp->comIn }}</td>
                            <td>{{ $emp->comOut }}</td>
                            <td>{{ $emp->comDate }}</td>
                        </tr>
                        <?php $no++;?>
                    @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
@extends('_main_layout')

@section('content')
<script type="text/javascript">
$(document).ready(function(){
    var x = $('#x').val();
    alert(x);
    new DataTable('#empTable', {
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'print'
        ],
    });
//    $('#empTable').DataTable({
//        dom: 'Bfrtip',
//        buttons: [
//            'excel', 'pdf', 'print'
//        ],
//        "pageLength": 20,
////        colReorder: {
//            order: [1, 2, x]
////        }
//    });
//    table.columns(['ids']).visible(true);
    
    $('#start_date,#end_date').datetimepicker({
        // useCurrent: false,
        format: 'Y-m-d',
        timepicker:false,
        // minDate: moment()
        // allowTimes: [
        //         '12:00', '12:30', '13:00', '13:30', '14:00',
        //         '14:30', '15:00', '15:30', '19:00', '20:00'
        //     ]
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
            <form action="{{ route('hrd.rekap_absen') }}" method="post" class ="form-inline">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="form-group">
                    <label for="start_date" class="sr-only">Name</label>
                    <input class="form-control" type="text" name="start_date" id="start_date" />
                </div>
                <div class="form-group">
                    <label for="end_date" class="sr-only">NIK</label>
                    <input class="form-control" type="text" name="end_date" id="end_date"/>
                </div>
                <div class="form-group">
                    <?php
//                    $project = \App\Models\Attendance\ComDept::lists('comDept','id')->prepend('-=Pilih=-', '0');
                    $project = \App\Models\Master\Location::lists('name','id')->prepend('-=Pilih=-', '0');
                    ?>
                    {!! Form::label('project', 'Project', ['class'=>'sr-only']) !!}
                    {!! Form::select('project', $project, '', ['class' => 'form-control', 'id' => 'project']) !!}
                </div>
                <button class="btn btn-success">Search</button>
            </form>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top: 20px;">
        <table id="empTable" class="table table-responsive table-striped">
            <thead>
            <tr>
                <th>NIK</th>
                <th>Nama</th>
                <?php $x= 3; ?>
                @for($i = new DateTime($start_date); $i <= new DateTime($end_date); $i->modify('+1 day'))
                <th id="{{ $x }}">{{ $i->format('m-d') }}</th>
                <?php $x++; ?>
                @endfor
                <th style="font-weight: bold;">Total</th>
            </tr>
            </thead>
            <input id="x" type="hidden" value="{{ $x }}" />
            <tbody>
            @foreach($arr as $row)
            <?php
            $add = 0;
            $begin2 = new DateTime( $start_date ); // 203.77.232.195
            $end2   = new DateTime( $end_date );?>
            <tr>
                <td><?= $row['nik']?></td>
                <td><?= $row['name']?></td>
            <?php
            for($j = $begin2; $j <= $end2; $j->modify('+1 day')){
                $new = $j->format('d-m');
                if(array_key_exists($new, $row) && !empty($row[$new])){
                    if($row['dept'] == '1' || $row['dept'] == '17'){
                        if($row[$new][1] <= '09:30:00'){
                            if(!empty($row[$new][3])){
                                if($row[$new][3] == 'TL' || $row[$new][3] == 'L' || $row[$new][3] == 'CB') {
                                    $add += 1;
                                    echo "<td>1 - ".$row[$new][3]."</td>";
                                }else if($row[$new][3] == 'CS'){
                                    $add += 0.5;
                                    echo "<td>0.5 - ".$row[$new][3]."</td>";
                                }else{
                                    echo "<td>0 - ".$row[$new][3]."</td>";
                                }
                            }else{
                                $add += 1;
                                echo "<td>1</td>";
                            }
                        }else{
                            echo "<td>0</td>";
                        }
                    }else{
                        if($row[$new][1] <= '08:30:00'){
                            if(!empty($row[$new][3])){
                                $add += 1;
                                echo "<td>1 - ".$row[$new][3]."</td>";
                            }else{
                                $add += 1;
                                echo "<td>1</td>";
                            }
                        }else{
                            echo "<td>0</td>";
                        }
                    }
            ?>
            <?php }else{ ?>
                <td>0</td>
            <?php }}?>
                <td>{{ $add }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>

@endsection
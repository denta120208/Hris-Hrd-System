@extends('_main_layout')

@section('content')
<style type="text/css">
    .popover {
        max-width: 400px; /* Lebar maksimum popover */
        width: 400px;     /* Lebar tetap */
        height: auto;     /* Tinggi otomatis menyesuaikan konten */
    }
    .col-xs-2 {
        width: 5%;
    }
</style>
<script type="text/javascript">
    $(document).ready(function(){
        $("[data-toggle=popover]").popover({
            container: 'body'
        });
        $("#form-factor input[type=text]").each(function() {
            $(this).change(function() {
                var max = parseInt($(this).attr('max'));
                $(this).val(Math.round(this.value));
                //alert(Math.round(this.value));
                if (Math.round(this.value) > max){
                    alert("Maximum Score : " + max);
                    $(this).val(max);
                    calculateSum();
                }
            });
        });
        calculateSum();

        $(".txtFact").on("keydown keyup", function() {
            calculateSum();
        });
        function calculateSum() {
            var sum = 0;
            //iterate through each textboxes and add the values
            $(".txtFact").each(function () {
                //add only if the value is number
                if (!isNaN(this.value) && this.value.length != 0) {
                    sum += Math.round(this.value)
//                    parseFloat(this.value);
                    $(this).css("background-color", "#FEFFB0");
                } else if (this.value.length != 0) {
                    alert("Format Number using period(.)");
                    $(this).css("background-color", "red");
                    $(this).val("0");
                }
            });

            //$("#total").val(sum.toFixed(2));
            $("#total").val(sum);
        }
    });
</script>
<div class="container"><?php
                       date_default_timezone_set('Asia/Jakarta');
    $new_date = date('Y-m-d', strtotime(substr($emp->joined_date, 0, 11)));
//                       print_r(\Carbon\Carbon::parse($emp->joined_date)); die;
//    $new_date = date('Y-m-d', strtotime($emp->joined_date));
    $date = new DateTime($new_date);
    $now = new DateTime();
    $interval = $now->diff($date);
    $yos = '';
    if($interval->y <= 1){
        $yos = $interval->y.' Year - '.$interval->m.' Months';
    }else{
        $yos = $interval->y.' Years -'.$interval->m.' Months';
    }
    ?>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <div class="col-lg-2 col-md-2 col-sm-2">
                @if($pic)
                    @if($pic->epic_picture_type == '2')
                        <img style="height: 150px;width: 250px;" class="img-responsive img-thumbnail" src="data:image/jpeg;base64,{{ base64_encode($pic->epic_picture) }}"/>
                    @elseif($pic->epic_picture_type == '1')
                        <img style="height: 150px;width: 250px;" class="img-responsive img-thumbnail" src="data:image/jpeg;base64,{{ $pic->epic_picture }}"/>
                    @else
                        <img src="{{ asset('images\personal\FOTO_DEFAULT.gif') }}">
                    @endif
                @else
                    <img src="{{ asset('images\personal\FOTO_DEFAULT.gif') }}">
                @endif
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <h3>{{ $emp->emp_firstname." ".$emp->emp_middle_name." ".$emp->emp_lastname }}</h3>
                <h4>{{ $emp->job_title->job_title }}</h4>
                <h4>DOB : {{ date('d-m-Y', strtotime(substr($emp->emp_birthday, 0, 11))) }}</h4>
                <h4>Years of Service : {{ $yos }}</h4>
        </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h4>Perizinan</h4>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Count</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $no = 1;?>
                    @foreach($ijin as $row)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ strtoupper($row->keterangan) }}</td>
                            <td>{{ $row->comIjin }}</td>
                            <td>{{ $row->id }}</td>
                        </tr>
                        <?php $no++;?>
                    @endforeach
                    </tbody>
                </table>
                <h4>Reward</h4>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Reward Type</th>
                        <th>Year</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($eRewards))
                        <?php $no = 1;?>
                        @foreach($eRewards as $row)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $row->reward_name->name }}</td>
                                <td>{{ $row->year_reward }}</td>
                            </tr>
                            <?php $no++;?>
                        @endforeach
                    @else
                        <td colspan="3">No Data</td>
                    @endif
                    </tbody>
                </table>
                <h3>Promotion</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Promotion Date</th>
                        <th>From</th>
                        <th>To</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($ePromots))
                        <?php $no = 1;?>
                        @foreach($ePromots as $row)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $row->promotion_date }}</td>
                                <td>{{ $row->promotion_from }}</td>
                                <td>{{ $row->promotion_to }}</td>
                                <?php $no++;?>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="6">No Data</td></tr>
                    @endif
                    </tbody>
                </table>
                <h3>Punishment</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Punishment Type</th>
                        <th>Year</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr><td colspan="3">No Data</td></tr>
                    </tbody>
                </table>
                <h3>Education</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Institution Name</th>
                        <th>Major</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($edus)
                        <?php $no = 1;?>
                        @foreach($edus as $row)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $row->education->name }}</td>
                                <td>{{ $row->institute }}</td>
                                <td>{{ $row->major }}</td>
                                <td>{{ $row->start_date }}</td>
                                <td>{{ $row->end_date }}</td>
                                <?php $no++;?>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="5">No Data</td></tr>
                    @endif
                    </tbody>
                </table>
                <h3>Training</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Training Name</th>
                        <th>Sertificate No</th>
                        <th>Sertificate Date</th>
                        <th>Expired Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($trains)
                        <?php $no = 1;?>
                        @foreach($trains as $row)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $row->trainning->name }}</td>
                                <td>{{ $row->license_no }}</td>
                                <td>{{ $row->license_issued_date }}</td>
                                <td>{{ $row->license_expiry_date }}</td>
                            </tr>
                            <?php $no++;?>
                        @endforeach
                    @else
                        <td colspan="5">No Data</td>
                    @endif
                    </tbody>
                </table>
            </div>
        <div style="margin-top: 110px;"></div>
        <div class="col-lg-12">
            <h3>Absence</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Year</th>
                        <th>S</th>
                        <th>I</th>
                        <th>< 8 Hours</th>
                    </tr>
                </thead>
                <tbody>
                <?php $no = 1;?>
                @foreach($arrDataAbsensiEmployee as $row)
                    <tr>
                        <td>{{ $no }}</td>
                        <td>{{ $row["tahun"] }}</td>
                        <td>{{ (float) $row["data"]->S }}</td>
                        <td>{{ (float) $row["data"]->I }}</td>
                        <td>{{ (float) $row["data"]->LESS_8_HOUR }}</td>
                    </tr>
                    <?php $no++;?>
                @endforeach
                </tbody>
            </table>
        </div>
        <div style="margin-top: 110px;"></div>
        <?php $sup_emp = \App\Models\Master\Employee::where('employee_id', Session::get('username'))->first(); ?>
        <div class="col-lg-12">
            <h3>Appraisal Form</h3>
            <form action="{{ route('setAppraisal') }}" method="POST" id="form-factor">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="emp_number" value="{{ $emp_number }}" />
                @foreach($appraisal as $row)
                    <?php 
                        $appraisal_category = DB::table('appraisal_category')
                                                ->where('id','=',$row->appraisal_cat)
                                                ->first();
                    ?>
                    @if($sup_emp->job_title_code >= '11')
                    <?php
                    $appraisals = DB::select("Select a.appraisal_value,b.emp_firstname,b.emp_middle_name,b.emp_lastname
                                from emp_appraisal as a INNER JOIN employee as b ON a.emp_evaluator = b.emp_number
                                where a.appraisal_id = ".$row->id."
                                and a.appraisal_status = 2
                                and a.emp_number = '".$emp_number."'"
                                . " AND and a.period = '".$year."'");
                    
//                    $appraisals = \App\Models\Employee\EmpAppraisal::join('employee', 'emp_appraisal.emp_evaluator', '=', 'employee.emp_number')
//                        ->select('emp_appraisal.appraisal_value', DB::raw("CONCAT([employee].[emp_firstname],' ', [employee].[emp_middle_name],' ', [employee].[emp_lastname]) AS fullname"))
//                        ->where('emp_appraisal.appraisal_id', $row->id)->where('emp_appraisal.appraisal_status', '2')->get(); ?>
                    @foreach($appraisals as $col)
                        <div class="col-lg-1">
                            <input style="text-align: center; width: 60px;" class="form-control" type="text" name="x" value="{{ (float) $col->appraisal_value }}" readonly ="yes" data-bs-toggle="tooltip" title="{{$col->emp_firstname.' '.$col->emp_middle_name.' '.$col->emp_lastname}}"/>
                        </div>
                    @endforeach
                    @endif
                    <div class="form-group" class="col-lg-12">
                        <label>({{$appraisal_category->name_appraisal}}) <br> {{ $row->factor }}</label>
                        <div class="col-lg-2">
                            @if(count($listAppraisal) <= 0)
                                <input type="hidden" name="appraisal_id[]" value="{{ $row->id }}" />
                                <input class="form-control txtFact" type="text" name="factor[]" id="factor" max="{{ $row->max_value }}"  style="text-align: center; width: 60px;" autocomplete="off" required="yes" />
                            @else
                                @foreach($listAppraisal as $row2)
                                    @if($row->id == $row2->appraisal_id)
                                        <input type="hidden" name="appraisal_id[]" value="{{ $row2->appraisal_id }}" />
                                        <input class="form-control txtFact" type="text" name="factor[]" value="{{ (float) $row2->appraisal_value}}" id="factor" max="{{ $row->max_value }}"  style="text-align: center; width: 60px;" autocomplete="off" required="yes" />
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        <a tabindex="0"
                           role="button"
                           data-html="true"
                           data-toggle="popover"
                           data-trigger="focus"
                           title=""
                           data-content="<div class='col-lg-12'><p>Kriteria 1 : {{ $row->tips_kurang }}</p>
                    <p>Kriteria 2 : {{ $row->tips_cukup }}</p>
                    <p>Kriteria 3 : {{ $row->tips_baik }}</p><p>Kriteria 4 : {{ $row->tips_sb }}</p></div>"><i class="fa fa-info-circle"></i></a>
                </div>
                @endforeach
                <div class="col-lg-3">
                    <br><br>
                    <label>Total Nilai</label>
                    <input class="form-control" type="text" name="total" id="total"  style="text-align: center; width: 60px; float:right;" autocomplete="off" readonly />
                </div>
                <p class="total"></p>
                
                <div class="col-lg-12">
                    <button class="btn btn-primary pull-right">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
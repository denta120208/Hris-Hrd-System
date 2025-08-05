@extends('_main_layout')

@section('content')
<style>
    .pagebreak { page-break-before: always; }
    @page {
        margin: 10mm;
        /*                margin-top: 94.08px;
                        margin-bottom: 75.84px;
                        margin-left: 94.08px;
                        margin-right: 75.84px;*/
    }

    ol.ur {list-style-type: upper-roman;}
    ol.la {list-style-type: lower-alpha;}
    ol.num {list-style-type: decimal;}
    ol.lr {list-style-type: lower-roman;}

    table, th, td {
        border: 0px black;
    }
    th, td {
        padding: 1px;
    }
    ol {
        list-style: none;
        margin: 0;
        padding: 5px;
    }
    li {
        text-align: justify;
        margin: 0;
        padding: 1px;
    }
    div.headeratas{
        padding-left: 2em;
        margin-left: 9em;
        text-align:center;
        margin-top:-1em;
        font-size: 10px
    }

    div.headeratas5{
        padding-left: 2em;
        margin-left: 9em;
        text-align:center;
        margin-top:5em;
        font-size: 10px
    }

    div.headeratastengah{
        text-align:right;
        margin-top:-98px;
    }
    div.headerbawahtengah{
        padding-left: 2em;
        margin-left: -1em;
        text-align:center;
        margin-top: 1em;
        font-size: 12px;
    }
    div.headerbawahtengah2{
        /*    padding-left: 5em;*/
        margin-left: 3em;
        text-align:center;
        margin-top: -1em;
        font-size: 12px;
        font-family: "Arial Narrow", Arial, sans-serif;
    }

    div.headerbawahtengah3{
            /*padding-left: 5em;*/
        /*margin-left: 3em;*/
        text-align:left;
        /*                margin-top: -1em;*/
        font-size: 14px;
        font-family: "Arial Narrow", Arial, sans-serif;
        /*margin-bottom: -30px;*/
    }

    .nomorsurat{
        /*    padding-left: 5em;*/
        /*                margin-left: 3em;*/
        text-align:center;
        margin-top: -1em;
        font-size: 22.5px;
        font-family: "Arial Narrow", Arial, sans-serif;
    }
    div.headerataskiri{
        text-align:left;
        margin-right:-7em;
        margin-top: -1em;
    }

    div.headerataskiri5{
        text-align:left;
        margin-right:-7em;
        margin-top: -30px;
        font-size: 9px;
    }

    div.headeratastengah5{
        padding-left: 2em;
        /*margin-left: 8em;*/
        text-align:left;
        margin-top: -30px;
        margin-left:20em;
        font-size: 9px;
    }

    div.headerataskanan5{
        margin-top:-30px;
        text-align:right;
        font-size: 9px;
    }
    div.headerbawahtengah5{
        /*    padding-left: 5em;*/
        margin-left: 5em;
        text-align:center;
        margin-top: 1em;
        font-size: 16px;
        font-family: Calibri, Helvetica, Arial, sans-serif;

    }

    div.headerbawahkiri{
        text-align:left;
    }
    div.headerataskanan{
        margin-top:2em;
        text-align:right;
        font-size: 8px;
    }

    div.headerbawahkanan{
        margin-top:-3em;
        text-align:right;
        font-size: 14px;
    }
    table.kananatas{
        align:right;
    }

    div.tanggalbawah{
        text-align: left;
        font-size: 11px;
    }


    div.ttdatas{
        margin-top:0em;
        text-align: center;
        font-size: 11px;
    }

    div.ttdbawah{
        margin-top:2em;
        text-align: left;
    }

    div.salesbawah{
        margin-top:0em;
        margin-right:8em;
        margin-bottom:5em;
        text-align: right;
    }

    div.bawah{
        margin-right:6em;
        text-align: right;
    }

    div.tableCustomer{
        /*                padding-left: 3em;*/
        font-size: 12px;
        font-family: "Arial Narrow", Arial, sans-serif;
    }
    div.termAndConditionAtas{
        text-align:left;
        font-size: 12px;
        margin-bottom:-1em;
        font-family: "Arial Narrow", Arial, sans-serif;
    }

    div.termAndConditionAtas2{
        text-align:left;
        font-size: 10px;
        margin-left: 10px;
        /*                 margin-bottom:-1em;*/
        font-family: "Arial Narrow", Arial, sans-serif;
    }

    div.termAndConditionBawah{
        text-align:left;
        margin-left: 3em;
        font-size: 14px;
        font-family: Calibri, Helvetica, Arial, sans-serif;
    }
    div.termAndConditionNextPage{
        text-align:left;
        padding: 1em;
        font-size: 12px;
        margin-top:0em;
    }

    div.rekeningAtasTermConditions{
        text-align:center;
        margin-left: 2em;
        font-size: 12px;
    }
    div.rekeningBawahTermConditions{
        text-align:center;
        margin-left: -2em;
        font-size: 12px;
    }

    div.Customer{
        /*                padding-left: 3em;*/
        font-size: 15px;
        font-family: "Arial Narrow", Arial, sans-serif;
    }

    div.dataBookingEntry{
        font-size: 12px;
        margin-top: -15px;
        font-family: "Arial Narrow", Arial, sans-serif;
    }

    div.page-break {
        page-break-after: always;
    }

    div.tabelCicilan{
        font-size: 13px;
        text-align: center;
        padding: 1em;
        padding-bottom: 1em;
    }

    div.parafTermCondition{
        text-align: right;
        font-size: 11px;
        /*     margin-bottom: -1000px;  */
    }

    table.table1{
        border-collapse: collapse;
        border: 1px solid black;
        width: 100%;
    }

    table.table1 tr{
        border-collapse: collapse;
        border: 1px solid black;
        height: 30px;
    }

    table.table1 td{
        border-collapse: collapse;
        border: 1px solid black;
    }

    table.table2{
        border-collapse: collapse;
        border: 1px solid black;
        width: 100%;
    }

    table.table2 tr{
        border-collapse: collapse;
        border: 1px solid black;
        height: 60px;
    }

    table.table2 td{
        border-collapse: collapse;
        border: 1px solid black;
    }

    table.tableSignature{
        border-collapse: collapse;
        border: 1px solid black;
        width: 100%;
    }

    table.tableSignature tr{
        border-collapse: collapse;
        border: 1px solid black;
        height: 0px;
    }

    table.tableSignature td{
        border-collapse: collapse;
        border: 1px solid black;
        /*height: 0px;*/
    }
    /*tr{*/
    /*    font-size: 11px;*/
    /*    text-align: left;*/
    /*    height: 20px;*/
    /*    vertical-align: bottom;*/
    /*}*/

    li{
        margin-bottom: 10px;
    }

    /*            #table{
                    font-size: 18px;
                    margin-top: -5em;
                    font-family: "Arial Narrow", Arial, sans-serif;
                }*/

    .header,
    .footer {
        width: 100%;
        text-align: center;
        position: fixed;
    }
    .header {
        top: 0px;
    }
    .footer {
        border-top: 2px solid #000;
        bottom: 0px;
    }
    .pagenum:before {
        content: counter(page);
    }

    div.halaman{
        border-right: 2px solid #000;
        text-align: left;
        font-family: "Arial Narrow", Arial, sans-serif;
        font-size: 12px;
        width: 10%;
    }
    div.notes{
        /*               border-left: 2px solid #000;*/
        margin-top: -20px;
        /*               position: absolute;*/
        text-align: right;
        font-family: "Arial Narrow", Arial, sans-serif;
        font-size: 12px;
        width: 100%;
    }
</style>

<div class="container">
    <div class="row">
        <table style="width:100%;margin-top: 20px;">
            <tr>
                <td>
                    <a class="btn btn-danger pull-left" href="{{ URL('/hrd/promotionapprbod/') }}">
                        <i>
                            << Back To List
                        </i>
                    </a>
                </td>
                <td>
                    <a href="#approveBOD{!!$id_request!!}" class="btn btn-success pull-right" data-toggle="modal">
                        <i>
                            Approve Promotion
                        </i>
                    </a>
                    <div id="approveBOD{!!$id_request!!}" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">  
                                    <h4 class="modal-title">Confirmation</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>    
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                            <p>Are you sure approve this request?</p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                                    <a href="{{ URL('/hrd/setPromotionBOD/'.$id_request) }}" class="btn btn-success">Yes</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
                <tr>
                    <!-- <td>
                        <div class="headerbawahtengah3">
                            <p><b>PT. METROPOLITAN LAND</b></p>
                        </div>
                    </td> -->
                    <!-- <td>
                        <div class="headerbawahtengah3" style="text-align: right;">
                            F-PROJECT/PER-06
                        </div>
                    </td> -->
                </tr>
                <!-- <tr>
                    <td>
                        <div class="headerbawahtengah3">
                            <p><b>DISTRIBUSI SURAT RILIS</b></p>
                        </div>
                    </td>
                </tr> -->
        </table>
        <br><br>
        <table style="width:60%;">
            <tr>
                <td rowspan="5">
                    @if($pic)
                        @if($pic->epic_picture_type == '2')
                            <img style="height: 150px;" class="img-responsive img-thumbnail" src="data:image/jpeg;base64,{{ base64_encode($pic->epic_picture) }}"/>
                        @elseif($pic->epic_picture_type == '1')
                            <img style="height: 150px;" class="img-responsive img-thumbnail" src="data:image/jpeg;base64,{{ $pic->epic_picture }}"/>
                        @else
                            <img src="{{ asset('images\personal\FOTO_DEFAULT.gif') }}">
                        @endif
                    @else
                        <img src="{{ asset('images\personal\FOTO_DEFAULT.gif') }}">
                    @endif
                </td>
            </tr>
            <tr>
                <td>
                    <div class="Customer">
                        Employee Name
                    </div>
                </td>
                <td>
                    <div class="Customer">
                        :
                    </div>
                </td>
                <td>
                    <div class="Customer">
                        {{$emp->emp_firstname}} {{$emp->emp_middle_name}} {{$emp->emp_lastname}}
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="Customer">
                        Date Of Birth
                    </div>
                </td>
                <td>
                    <div class="Customer">
                        :
                    </div>
                </td>
                <td>
                    <div class="Customer">
                        {{$emp_birthday}}
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="Customer">
                        Period of Employment
                    </div>
                </td>
                <td>
                    <div class="Customer">
                        :
                    </div>
                </td>
                <td>
                    <div class="Customer">
                        {{$yos}}
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="Customer">
                        Job Level
                    </div>
                </td>
                <td>
                    <div class="Customer">
                        :
                    </div>
                </td>
                <td>
                    <div class="Customer">
                        {{$emp->job_title->job_title}}
                    </div>
                </td>
            </tr>
        </table>
        <br><br>
        <table class="table1">
            <tr style="background-color: #c2c2a3;">
                <td colspan="4"><div class="Customer"><b>Attendance (2 Years Before)</b></div></td>
            </tr>
            <tr>
                <td><div class="Customer"><center><b>No.</b></center></div></td>
                <td><div class="Customer"><center><b>Description</b></center></div></td>
                <td><div class="Customer"><center><b>Code</b></center></div></td>
                <td><div class="Customer"><center><b>Total</b></center></div></td>
            </tr>
            @if(count($ijin) > 0)
                <?php
                    $no = 1;
                    $total = 0;
                ?>
                @foreach($ijin as $data)
                <tr>
                    <td style="text-align:center;"><div class="Customer">{{$no}}</div></td>
                    <td><div class="Customer">{{$data->keterangan}}</div></td>
                    <td><div class="Customer">{{$data->comIjin}}</div></td>
                    <td style="text-align:right;"><div class="Customer">{{$data->id}}</div></td>
                </tr>
                <?php 
                    $no += 1; 
                    $total += $data->id;
                ?>
                @endforeach
            @else
                <tr>
                    <td colspan="4"><div class="Customer"><center>No Data</center></div></td>
                </tr>
            @endif
            <tr style="background-color: #c2c2a3;">
                <td colspan="3"><div class="Customer"><b>TOTAL</b></div></td>
                <td style="text-align:right;"><div class="Customer"><b>{{$total}}</b></div></td>
            </tr>
        </table>
        <br><br>
        <table class="table1">
            <tr style="background-color: #c2c2a3;">
                <td colspan="3"><div class="Customer"><b>Rewards</b></div></td>
            </tr>
            <tr>
                <td><div class="Customer"><center><b>No.</b></center></div></td>
                <td><div class="Customer"><center><b>Rewards</b></center></div></td>
                <td><div class="Customer"><center><b>Year</b></center></div></td>
            </tr>
            @if(count($eRewards) > 0)
                <?php
                    $noReward = 1; 
                ?>
                @foreach($eRewards as $dataReward)
                <tr>
                    <td style="text-align:center;"><div class="Customer">{{$noReward}}</div></td>
                    <td><div class="Customer">{{$dataReward->reward_name->name}}</div></td>
                    <td><div class="Customer"><center>{{$dataReward->year_reward}}</center></div></td>
                </tr>
                <?php 
                    $noReward += 1; 
                ?>
                @endforeach
            @else
                <tr>
                    <td colspan="3"><div class="Customer"><center>No Data</center></div></td>
                </tr>
            @endif
            <tr style="background-color: #c2c2a3;">
                <td colspan="3"><div class="Customer"><b></b></div></td>
            </tr>
        </table>
        <br><br>
        <table class="table1">
            <tr style="background-color: #c2c2a3;">
                <td colspan="4"><div class="Customer"><b>Demotion</b></div></td>
            </tr>
            <tr>
                <td><div class="Customer"><center><b>No.</b></center></div></td>
                <td><div class="Customer"><center><b>Demotion Date</b></center></div></td>
                <td><div class="Customer"><center><b>From</b></center></div></td>
                <td><div class="Customer"><center><b>To</b></center></div></td>
            </tr>
            @if(count($ePromots) > 0)
                <?php 
                    $noDemotion = 1; 
                ?>
                @foreach($ePromots as $dataDemotion)
                <tr>
                    <td style="text-align:center;"><div class="Customer">{{$noDemotion}}</div></td>
                    <td><div class="Customer">{{$dataDemotion->promotion_date}}</div></td>
                    <td><div class="Customer"><center>{{$dataDemotion->promotion_from}}</center></div></td>
                    <td><div class="Customer"><center>{{$dataDemotion->promotion_to}}</center></div></td>
                </tr>
                <?php 
                    $noDemotion += 1; 
                ?>
                @endforeach
            @else
                <tr>
                    <td colspan="4"><div class="Customer"><center>No Data</center></div></td>
                </tr>
            @endif
            <tr style="background-color: #c2c2a3;">
                <td colspan="4"><div class="Customer"><b></b></div></td>
            </tr>
        </table>
        <br><br>
        <table class="table1">
            <tr style="background-color: #c2c2a3;">
                <td colspan="4"><div class="Customer"><b>Punishment</b></div></td>
            </tr>
            <tr>
                <td><div class="Customer"><center><b>No.</b></center></div></td>
                <td><div class="Customer"><center><b>Date</b></center></div></td>
                <td><div class="Customer"><center><b>Punishment</b></center></div></td>
                <td><div class="Customer"><center><b>Reason</b></center></div></td>
            </tr>
            @if(count($ePunish) > 0)
                <?php 
                    $noPunish = 1; 
                ?>
                @foreach($ePunish as $dataPunish)
                <tr>
                    <td style="text-align:center;"><div class="Customer">{{$noPunish}}</div></td>
                    <td><div class="Customer">{{$dataPunish->hrd_approved_at}}</div></td>
                    <td><div class="Customer"><center>{{$dataPunish->punish_type}}</center></div></td>
                    <td><div class="Customer"><center>{{$dataPunish->punish_reason}}</center></div></td>
                </tr>
                <?php 
                    $noPunish += 1; 
                ?>
                @endforeach
            @else
                <tr>
                    <td colspan="4"><div class="Customer"><center>No Data</center></div></td>
                </tr>
            @endif
            <tr style="background-color: #c2c2a3;">
                <td colspan="4"><div class="Customer"><b></b></div></td>
            </tr>
        </table>
        <br><br>
        <table class="table1">
            <tr style="background-color: #c2c2a3;">
                <td colspan="4"><div class="Customer"><b>Appraisal</b></div></td>
            </tr>
            <tr>
                <td><div class="Customer"><center><b>No.</b></center></div></td>
                <td><div class="Customer"><center><b>Year</b></center></div></td>
                <td><div class="Customer"><center><b>Result Amount</b></center></div></td>
                <td><div class="Customer"><center><b>Result Code</b></center></div></td>
            </tr>
            @if(count($eAppraisal) > 0)
                <?php 
                    $noAppraisal = 1; 
                ?>
                @foreach($eAppraisal as $dataAppraisal)
                <tr>
                    <td style="text-align:center;"><div class="Customer">{{$noAppraisal}}</div></td>
                    <td><div class="Customer"><center>{{$dataAppraisal->years}}</center></div></td>
                    <td><div class="Customer"><center>{{$dataAppraisal->appraisal_result_val}}</center></div></td>
                    <td><div class="Customer"><center>{{$dataAppraisal->box9}}</center></div></td>
                </tr>
                <?php 
                    $noAppraisal += 1; 
                ?>
                @endforeach
            @else
                <tr>
                    <td colspan="4"><div class="Customer"><center>No Data</center></div></td>
                </tr>
            @endif
            <tr style="background-color: #c2c2a3;">
                <td colspan="4"><div class="Customer"><b></b></div></td>
            </tr>
        </table>
        <br><br>
        <table class="table1">
            <tr style="background-color: #c2c2a3;">
                <td colspan="6"><div class="Customer"><b>Education</b></div></td>
            </tr>
            <tr>
                <td><div class="Customer"><center><b>No.</b></center></div></td>
                <td><div class="Customer"><center><b>Level</b></center></div></td>
                <td><div class="Customer"><center><b>Institution</b></center></div></td>
                <td><div class="Customer"><center><b>Major</b></center></div></td>
                <td><div class="Customer"><center><b>Start</b></center></div></td>
                <td><div class="Customer"><center><b>End</b></center></div></td>
            </tr>
            @if(count($edus) > 0)
                <?php
                    $noEdus = 1;
                ?>
                @foreach($edus as $dataEdus)
                <tr>
                    <td style="text-align:center;"><div class="Customer">{{$noEdus}}</div></td>
                    <td><div class="Customer">{{$dataEdus->education->name}}</div></td>
                    <td><div class="Customer">{{$dataEdus->institute}}</div></td>
                    <td><div class="Customer">{{$dataEdus->major}}</div></td>
                    <td><div class="Customer"><center>{{date('d-m-Y', strtotime(substr($dataEdus->start_date, 0, 11)))}}</center></div></td>
                    <td><div class="Customer"><center>{{date('d-m-Y', strtotime(substr($dataEdus->end_date, 0, 11)))}}</center></div></td>
                </tr>
                <?php 
                    $noEdus += 1; 
                ?>
                @endforeach
            @else
                <tr>
                    <td colspan="6"><div class="Customer"><center>No Data</center></div></td>
                </tr>
            @endif
            <tr style="background-color: #c2c2a3;">
                <td colspan="6"><div class="Customer"><b></b></div></td>
            </tr>
        </table>
        <br><br>
        <table class="table1">
            <tr style="background-color: #c2c2a3;">
                <td colspan="5"><div class="Customer"><b>Training</b></div></td>
            </tr>
            <tr>
                <td><div class="Customer"><center><b>No.</b></center></div></td>
                <td><div class="Customer"><center><b>Training</b></center></div></td>
                <td><div class="Customer"><center><b>Sertificate</b></center></div></td>
                <td><div class="Customer"><center><b>Sertificate Date</b></center></div></td>
                <td><div class="Customer"><center><b>Sertificate Exp. Date</b></center></div></td>
            </tr>
            @if(count($trains) > 0)
                <?php
                    $noTrain = 1;
                ?>
                @foreach($trains as $dataTraining)
                <tr>
                    <td style="text-align:center;"><div class="Customer">{{$noTrain}}</div></td>
                    @if($dataTraining->license_id == 1)
                        <td>{{$dataTraining->train_name}}</td>
                    @else
                        <td>{{$dataTraining->trainning->name}}</td>
                    @endif
                    <td><div class="Customer">{{$dataTraining->license_no}}</div></td>
                    <td><div class="Customer"><center>{{date('d-m-Y', strtotime(substr($dataTraining->license_issued_date, 0, 11)))}}</center></div></td>
                    <td><div class="Customer"><center>{{date('d-m-Y', strtotime(substr($dataTraining->license_expiry_date, 0, 11)))}}</center></div></td>
                </tr>
                <?php 
                    $noTrain += 1; 
                ?>
                @endforeach
            @else
                <tr>
                    <td colspan="5"><div class="Customer"><center>No Data</center></div></td>
                </tr>
            @endif
            <tr style="background-color: #c2c2a3;">
                <td colspan="5"><div class="Customer"><b></b></div></td>
            </tr>
        </table>
        <br><br>
        <table class="table1">
            <tr style="background-color: #c2c2a3;">
                <td colspan="4"><div class="Customer"><b>Mutation</b></div></td>
            </tr>
            <tr>
                <td><div class="Customer"><center><b>No.</b></center></div></td>
                <td><div class="Customer"><center><b>From</b></center></div></td>
                <td><div class="Customer"><center><b>To</b></center></div></td>
                <td><div class="Customer"><center><b>Reason</b></center></div></td>
            </tr>
            <tr>
                <td colspan="4"><div class="Customer"><center>No Data</center></div></td>
            </tr>
            <tr style="background-color: #c2c2a3;">
                <td colspan="5"><div class="Customer"><b></b></div></td>
            </tr>
    </table>
    <table style="width:100%;margin-top: 20px;">
        <tr>
            <td>
                <a class="btn btn-danger pull-left" href="{{ URL('/hrd/promotionapprbod/') }}">
                    <i>
                        << Back To List
                    </i>
                </a>
            </td>
            <td>
                <a href="#approveBOD{!!$id_request!!}" class="btn btn-success pull-right" data-toggle="modal">
                    <i>
                        Approve Promotion
                    </i>
                </a>
                <div id="approveBOD{!!$id_request!!}" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">  
                                <h4 class="modal-title">Confirmation</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>    
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                        <p>Are you sure approve this request?</p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                                <a href="{{ URL('/hrd/setPromotionBOD/'.$id_request) }}" class="btn btn-success">Yes</a>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    </div>
</div>
@endsection
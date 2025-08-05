@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        $('#appraisalTable').DataTable({
            scrollX: "100%",
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            pageLength: 10,
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excel'
                }
                // {
                //     extend: 'pdfHtml5',
                //     orientation: 'portrait',
                //     pageSize: 'A4'
                // },
                // {
                //     extend: 'print'
                // }
            ]
        });
    });
</script>
<div class="container">
    <h2>Appraisal Adjustment</h2>
    <div class="row">
        <div class="col-md-12">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <form action="{{ route('hrd.viewAdjAppraisal') }}" method="post">
            <div class="col-lg-4">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="form-group">
                    {!! Form::label('location_id', 'Project') !!}<br>
                    <select class="form-control" name="location_id" id="location_id">
                        <option value="">--- Not Selected ---</option>
                        @foreach($dataLocation as $data)
                        <option value="{{ $data->id }}" {{ $param['location_id'] == $data->id ? "selected" : "" }}>{{ $data->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    {!! Form::label('periodYear', 'Year') !!}<br>
                    <select name="periodYear" id="periodYear" class="form-control">
                        @for ($i=2024;$i<=2034;$i++)
                            @if($i == $year)
                                <option value="{{$i}}" selected>{{$i}}</option>
                            @else
                                <option value="{{$i}}">{{$i}}</option>
                            @endif
                        @endfor    
                    </select>
                </div>
                <div class="form-group pull-right">
                    <label style="visibility: hidden;">action</label><br>
                    <button class="btn btn-success">Search</button>
                </div>
            </div>
        </form>
        <div style="margin-bottom: 140px;"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="data-table-list">
                <div class="table-responsive">
                    <?php $no = 1; ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <h4><b>Project: {{ empty($param['location_name']) ? "-" : $param['location_name'] }}</b></h4>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <h4><b>Year: {{ empty($param['periodYear']) ? "-" : $param['periodYear'] }}</b></h4>
                            </div>
                        </div>
                    </div>
                    @if($viewData == -1) 
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <a target="_blank" class="btn btn-sm btn-info" href="{{ URL('/hrd/print_appraisal_emp/'  . $dirops_dept_id . '/' . $periodYear) }}" onclick="window.open(this.href).print(); return false">
                                    <i>
                                        Print Data Appraisal
                                    </i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                    <!-- <br> -->
                    <form action="{{ route('finalisasiAdj') }}" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <table id="appraisalTable" class="table table-responsive table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <!-- <th><input type="checkbox" onchange="checkAll(this)" name="empid[]"/></th> -->
                                                <th></th>
                                                {{-- <th>Project</th> --}}
                                                <th>NIK</th>
                                                <th>Nama</th>
                                                <th>Level</th>
                                                {{-- <th>Division</th> --}}
                                                <th>Department</th>
                                                {{-- <th>Status Karyawan</th> --}}
                                                <th>Kategori Form PA</th>
                                                {{-- <th>Tahun Appraisal</th> --}}
                                                <th>Nilai Awal</th>
                                                <th>Item Pengurangan (ST/SP1/SP2/SP3)</th>
                                                <th>Nilai Akhir</th>
                                                <th>Nilai Final</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($dataAppraisal as $appr)
                                            <tr>
                                                <td>{{ $no }}</td>
                                                @if($appr->is_final == 0)
                                                    <td><input name="empid[]" type="checkbox" onchange="selected(this,<?php echo $appr->emp_number;  ?>)" value="<?php echo $appr->emp_number;  ?>" id="idemp"></td>
                                                @else
                                                    <td></td>
                                                @endif
                                                {{-- <td>{{ $appr->location_name }}</td> --}}
                                                <td>{{ $appr->nik }}</td>
                                                <td>{{ $appr->emp_fullname }}</td>
                                                <td>{{ $appr->job_title }}</td>
                                                {{-- <td>{{ $appr->division }}</td> --}}
                                                <td>{{ $appr->department }}</td>
                                                {{-- <td>{{ $appr->employment_status }}</td> --}}
                                                <td class="text-center">{{ $appr->code_appraisal }}</td>
                                                {{-- <td>{{ $appr->period_year }}</td> --}}
                                                <td class="text-right">{{ number_format($appr->nilai_awal,0,',',',') }}</td>
                                                <td class="text-right">{{ $appr->item_pengurangan }}</td>
                                                <td class="text-center">{{ number_format($appr->nilai_akhir,0,',',',') }}</td>
                                                <td class="text-center">{{ number_format($appr->final_value,0,',',',') }}</td>
                                                @if($appr->is_final == 0)
                                                    <td>
                                                        <a href="javascript:void(0)" onclick="adjAppraisal('<?php echo $appr->emp_number ?>', '<?php echo $appr->nik ?>', '<?php echo $appr->emp_fullname ?>', '<?php echo $appr->period_year ?>', '<?php echo number_format($appr->nilai_akhir,0,',',',') ?>')">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    </td>
                                                @else
                                                    <td></td>
                                                @endif
                                            </tr>
                                            <?php $no++; ?>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                @if(!empty($location_id))
                                    @if(empty($appraisal_attach))
                                    <div class="form-group">
                                        <label>Upload File Appraisal <span style="color: red;">(PDF Only)</span></label>
                                        <input type="file" class="form-control" name="pdf_file" accept=".pdf" /><br>
                                    </div>
                                    @else
                                    <div class="form-group">
                                        <label>File Appraisal</label>
                                        <br>
                                        <a href="{{ URL::route("downloadFileAttachmentAdj", [$appraisal_attach[0]->emp_appraisal_attch_id]) }}"><b>{{ $appraisal_attach[0]->filename }}</b></a>
                                    </div>
                                    @endif
                                @else
                                @endif
                                <div id="temp-form">
                                    <input type="hidden" name="selectall" value="none" class="form-control" id="all">
                                    <input type="hidden" name="employee" value="0" class="form-control" id="0">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <input type="hidden" name="periodYear" value="{{ $periodYear }}" />
                                    <input type="hidden" name="location_id" value="{{ $location_id }}" />
                                </div>
                                <br>
                                <div class="form-group">
                                    <a href="#confModal" class="btn btn-primary pull-right" data-toggle="modal" style="float: right;">
                                        Finalisasi
                                    </a>
                                    <div id="confModal" class="modal fade">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Confirmation</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure Finalization this data ?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                                                    <button type="submit" class="btn btn-success">Yes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <br><br>
                    <!-- <form action="{{ route('uploadAttachmentAdj') }}" method="post" enctype="multipart/form-data">
                        
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <a href="#uploadModal" class="btn btn-primary" data-toggle="modal" style="float: right;">
                                        Upload
                                    </a>
                                    <div id="uploadModal" class="modal fade">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Confirmation</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure upload this data ?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Upload</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form> -->
                </div>
            </div>
        </div>
    </div>
</div>
<div id="adjModal1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="adjModal1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                <h4 class="modal-title" id="adjModal1">Adjustment Appraisals</h4>
            </div>
            <form action="{{ route('setAdjAppraisal') }}" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="emp_number" id="emp_number" />
                    <div class="form-group">
                        <label for="employee_id">NIK<span style="color: red;">*</span></label>
                        <input class="form-control" type="text" name="employee_id" id="employee_id" readonly="readonly" />
                    </div>
                    <div class="form-group">
                        <label for="emp_fullname">Nama<span style="color: red;">*</span></label>
                        <input class="form-control" type="text" name="emp_fullname" id="emp_fullname" readonly="readonly" />
                    </div>
                    <div class="form-group">
                        <label for="period_year">Tahun Appraisal<span style="color: red;">*</span></label>
                        <input class="form-control" type="text" name="period_year" id="period_year" readonly="readonly" />
                    </div>
                    <div class="form-group">
                        <label for="nilai_akhir">Nilai Final<span style="color: red;">*</span></label>
                        <input class="form-control" type="text" name="nilai_akhir" id="nilai_akhir" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $("#periodYear").datepicker( {
            format: "yyyy",
            startView: "months", 
            minViewMode: "months"
        });

        $('#periodYear').on('changeDate', function(ev){
            $(this).datepicker('hide');
        });
        
        // $('.datepicker').datepicker({
        //     format: 'dd/mm/yyyy',
        //     todayHighlight:'TRUE',
        //     autoclose: true,
        //     orientation: 'auto bottom'
        // });

        $('#banklist').dataTable();

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    });
</script>

<script>
    function adjAppraisal(emp_number, employee_id, emp_fullname, period_year, nilai_akhir) {
        $("#emp_number").val(emp_number);
        $("#employee_id").val(employee_id);
        $("#emp_fullname").val(emp_fullname);
        $("#period_year").val(period_year);
        $("#nilai_akhir").val(nilai_akhir);
        $('#adjModal1').modal('show');
    }

    function checkAll(ele) {
        var checkboxes = document.getElementsByTagName('input');
        if (ele.checked) {
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = true;
                    //document.getElementById(i).remove();
                }
            }
            document.getElementById('all').remove();
            var tz = $('<div />')
            tz.append($("<input />", { type: 'hidden', name: 'selectall', value: 'all', class: 'form-control',id: 'all'}))
            tz.appendTo('#temp-form');
        } else {
            for (var i = 0; i < checkboxes.length; i++) {
                console.log(i)
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = false;
                    //document.getElementById(i).remove();
                }
            }
            document.getElementById('all').remove();
            var tz = $('<div />')
            tz.append($("<input />", { type: 'hidden', name: 'selectall', value: 'none', class: 'form-control',id: 'all'}))
            tz.appendTo('#temp-form');
        }
    }

    function selected(ele,employeeid){
        //alert(billid);
        if (ele.checked) {
            var tz = $('<div />')
            tz.append($("<input />", { type: 'hidden', name: 'employee[]', value: employeeid, class: 'form-control',id: employeeid}))
            tz.appendTo('#temp-form');
        } else {
            //alert(ele);
            document.getElementById(employeeid).remove();
        }
    }
</script>
<?php

function formatDate($date, $format = 'Y-m-d') {
    if (!empty($date)) {
        $dat = \DateTime::createFromFormat($format, $date);
        $stat = $dat && $dat->format($format) === $date;
        if ($stat == false) {
            $finalDate = \DateTime::createFromFormat('M d Y h:i:s A', $date)->format($format);
        } else {
            $finalDate = $date;
        }
        return $finalDate;
    } else {
        return "";
    }
}
?>
@endsection
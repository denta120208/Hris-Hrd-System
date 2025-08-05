@extends('_main_layout')

@section('content')
{{--<script type="text/javascript">--}}
{{--    $(document).ready(function(){--}}
{{--        $("#appraisalCat").change(function(){--}}
{{--            var e = document.getElementById("type");--}}
{{--            var id = e.options[e.selectedIndex].value;--}}
{{--            $.ajax({--}}
{{--                url: '{{ route('getAppraisalType') }}',--}}
{{--                type: 'get',--}}
{{--                data: {id:id},--}}
{{--                dataType: 'json',--}}
{{--                success:function(response){--}}
{{--                    $('#balance').val(response.balance);--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}
<script>
    $(document).ready(function () {
        $('#table-appraisal').dataTable();
    });
</script>
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="data-table-list">
                <div class="table-responsive">
                    <h2>Appraisal</h2>
                    <table id="table-appraisal" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIK</th>
                                <th>Name</th>
                                <th>Year</th>
<!--                                <th>Emp Appraisal</th>-->
                                <th>Sup Appraisal</th>
                                <th>Dir Appraisal</th>
<!--                                <th>Final Score</th>-->
                                <th></th>
                        {{--                        <th></th>--}}
                            </tr>
                        </thead>
                    <tbody>
                            @if($subs)
                            <?php $no = 1; ?>
                            @foreach($subs as $row)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $row->employee_id }}</td>
                                <td>{{ $row->emp_firstname." ".$row->emp_middle_name." ".$row->emp_lastname }}</td>
                                <td>{{ $row->appraisal_year_period }}</td>
                                @if($row->evaluator_status == '1')
<!--                                <td>{{ $row->emp_value  }}</td>-->
                                <td>{{ $row->sup_value  }}</td>
                                <td>{{ $row->dir_value  }}</td>
<!--                                <td>{{ $row->hrd_value  }}</td>-->
                                @elseif($row->evaluator_status == '2')
<!--                                <td>{{ $row->emp_value  }}</td>-->
                                <td>@if($row->appraisal_value <> null) {{ $row->appraisal_value." / ".$row->sup_value  }} @else {{ $row->sup_value }} @endif</td>
                                <td>{{ $row->dir_value  }}</td>
<!--                                <td>{{ $row->hrd_value  }}</td>-->
                                @elseif($row->evaluator_status == '3')
<!--                                <td>{{ $row->emp_value  }}</td>-->
                                <td>{{ $row->sup_value  }}</td>
                                <td>@if($row->appraisal_value <> null) {{ $row->appraisal_value  }} @else {{ $row->dir_value }} @endif</td>
<!--                                <td>{{ $row->hrd_value  }}</td>-->
                                @elseif($row->evaluator_status == '4')
<!--                                <td>0</td>-->
                                <td>0</td>
                                <td>0</td>
<!--                                <td>{{ $row->appraisal_value  }}</td>-->
                                @else
<!--                                <td>0</td>-->
                                <td>0</td>
                                <td>0</td>
<!--                                <td>0</td>-->
                                @endif
                                @if($row->appraisal_status <= '1')
                                <td>
                                    <a href="{{ route('appraisal.add', $row->emp_evaluation) }}"><i class="fa fa-plus"></i></a>
                                </td>
                                <td>
                                    <a href="{{ route('appraisal.final', [$row->emp_evaluation, $row->emp_number]) }}"><i class="fa fa-check"></i></a>
                                </td>
                                <td>
                                    <i class="fa fa-print"></i>
                                </td>
                                @else
                                <td>
                                    <a href="/hrd/print_appraisal/{{ $row->emp_number_karyawan }}/{{ $row->emp_number }}" onclick="window.open(this.href).print(); return false"><i class="fa fa-print"></i></a>
                                </td>
                                {{--                                <td>--}}
                            {{--                                    <i class="fa fa-check-circle"></i>--}}
                                {{--                                </td>--}}
                                @endif
                            </tr>
                            <?php $no += 1; ?>
                            @endforeach
                            @else
                            <!--<tr><td colspan="9">No Record</td></tr>-->
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
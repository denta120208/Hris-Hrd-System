@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#empTable').DataTable({
            dom: 'l<"toolbar">frtip',
            "pageLength": 50,
        });
        $('#empTable').on('click', 'tbody tr', function () {
            var data = table.row($(this)).data();
            var id = $(data[0]).attr("data-id"); // get attribute data-id from TD
            alert(id);
            // window.location = "/hrd/rAge/"+id+"/show";
        });
    });
</script>
<div class="container">
    <h2>Age Detail Report</h2>
    <div style="margin-bottom: 50px;"></div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="data-table-list">
                <div class="table-responsive">
                    <?php $no = 1;
                    $kt = $kr = $tkt = $tkr = 0; ?>
                    <table id="empTable" class="table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIK</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Range Category</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($datas as $data)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $data->employee_id }}</td>
                                <td>{{ $data->emp_firstname." ".$data->emp_middle_name." ".$data->emp_lastname }}</td>
                                <td>{{ $data->umur }}</td>
                                <td>@if($data->range_umur == 'r1')
                                    < 25
                                    @elseif($data->range_umur == 'r2')
                                    25-35
                                    @elseif($data->range_umur == 'r3')
                                    36-45
                                    @elseif($data->range_umur == 'r4')
                                    46-55
                                    @elseif($data->range_umur == 'r5')
                                    > 56
                                    @endif
                                </td>
                            </tr>
<?php $no++; ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{--],--}}
{{--[],--}}
{{--[],--}}
{{--[],--}}
{{--[ --}}
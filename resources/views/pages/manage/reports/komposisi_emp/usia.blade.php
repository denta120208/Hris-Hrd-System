@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#empTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'excel', 'pdf', 'print'
            ],
            "pageLength": 50,
        });
        $('#empTable').on('click', 'tbody tr', function () {
            var data = table.row($(this)).data();
            var id = $(data[0]).attr("data-id"); // get attribute data-id from TD
            window.location = "/hrd/rAge/" + id + "/show";
        });
    });
</script>
<div class="container">
    <h2>Age Report</h2>
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
                                <th>Proyek</th>
                                <th> < 25 </th>
                                <th> 25-35 </th>
                                <th> 36-45 </th>
                                <th> 46-55 </th>
                                <th> > 56 </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($datas as $data)
                            <tr>
                                <td><span data-id='{{ $data->project_id }}'>{{ $no }}</span></td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->r1 }}</td>
                                <td>{{ $data->r2 }}</td>
                                <td>{{ $data->r3 }}</td>
                                <td>{{ $data->r4 }}</td>
                                <td>{{ $data->r5 }}</td>
                            </tr>
<?php $no++; ?>
                            @endforeach
                            {{--                <tr>--}}
                            {{--                    <td>2</td>--}}
                            {{--                    <td>Komersial</td>--}}
                            {{--                    <td>{{ $kt }}</td>--}}
                            {{--                    <td>{{ $kr }}</td>--}}
                            {{--                    <td>{{ $kt + $kr }}</td>--}}
                            {{--                </tr>--}}
                            {{--                <tr style="font-weight: bold;">--}}
                            {{--                    <td colspan="4">Grand Total</td>--}}
                            {{--                    <td>{{ $tkt + $tkr }}</td>--}}
                            {{--                </tr>--}}
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
@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        $('#empTable').DataTable({
            "pageLength": 20
        });
    });
</script>
<div class="container">
    <h2>Gender Report</h2>
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
                                <th>Project</th>
                                <th>Male</th>
                                <th>Female</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($datas as $data)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->Male }}</td>
                                <td>{{ $data->Female }}</td>
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
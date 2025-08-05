@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function(){
        $('#leave').addClass("active");
        $('#mailbox').addClass("in active");
        $('#personal').removeClass("active");
        $('#Home').removeClass("in active");
    });
</script>
    <div class="container">
        <input type="hidden" id="addClasses" value="active" />
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="data-table-list">
{{--                    <div class="basic-tb-hd">--}}
{{--                        <h2>Basic Example</h2>--}}
{{--                        <p>It's just that simple. Turn your simple table into a sophisticated data table and offer your users a nice experience and great features without any effort.</p>--}}
{{--                    </div>--}}
                    <div class="table-responsive">
                        <h2>My Leave</h2>
                        <table id="data-table-basic" class="table table-striped">
                            <thead>
                            <tr>
                                <th>Leave Types</th>
                                <th>Entitlement Type</th>
                                <th>Valid From</th>
                                <th>Valid To</th>
                                <th>Days</th>
                                <th>Taken</th>
                                <th>Balance</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($balLeave)
                                @foreach($balLeave as $row)
                            <tr>
                                <td>{{ $row->entitlement_title->name }}</td>
                                <td>-</td>
                                <td>{{ date('d-m-Y', strtotime($row->from_date)) }}</td>
                                <td>{{ date('d-m-Y', strtotime($row->to_date)) }}</td>
                                <td>{{ $row->no_of_days }}</td>
                                <td>{{ $row->days_used }}</td>
                                <td>{{ $row->no_of_days - $row->days_used }}</td>
                            </tr>
                                @endforeach
                            @else
                            <tr><td>No Entitlement</td></tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('_main_layout')
<script type="text/javascript">
    $(document).ready(function(){
        {{--function check_leave(){--}}
        {{--    $.ajax({--}}
        {{--        type: 'get',--}}
        {{--        url: "{{ route('dashboard.ckLeave') }}",--}}
        {{--        data: 'id='+ yourid,--}}
        {{--        // cache: false,--}}
        {{--        success: function(response){}--}}
        {{--    });--}}
        {{--}--}}
        {{--function check_train(){--}}
        {{--    $.ajax({--}}
        {{--        type: 'get',--}}
        {{--        url: "{{ route('dashboard.ckTrain') }}",--}}
        {{--        data: 'id='+ yourid,--}}
        {{--        // cache: false,--}}
        {{--        success: function(response){}--}}
        {{--    });--}}
        {{--}--}}
        {{--$.ajax({--}}
        {{--    url: "{{ route('dash_chart') }}",--}}
        {{--    success: function(results) {--}}
        {{--        var data = [];--}}
        {{--        var labels =  [];--}}
        {{--        $.each(results, function(index) {--}}
        {{--            // console.log(data[index].range_umur);--}}
        {{--            data[index] = results[index].counter;--}}
        {{--            labels[index] = results[index].range_umur;--}}
        {{--        });--}}
        {{--        renderChartAge(data, labels);--}}
        {{--    }--}}
        {{--});--}}
        {{--$.ajax({--}}
        {{--    url: "{{ route('dash_chart2') }}",--}}
        {{--    success: function(results) {--}}
        {{--        var data = [];--}}
        {{--        var labels =  [];--}}
        {{--        $.each(results, function(index) {--}}
        {{--            // console.log(data[index].range_umur);--}}
        {{--            data[index] = results[index].counters;--}}
        {{--            labels[index] = results[index].gender;--}}
        {{--        });--}}
        {{--        renderChartGender(data, labels);--}}
        {{--    }--}}
        {{--});--}}
    });
</script>
<style>
    .pre-scrollable-dash {
        max-height: 420px;
        overflow-y: scroll;
    }
</style>

<script type="text/javascript">
    function renderChartAge(data, labels) {
        var ctx = document.getElementById("age").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Age',
                    data: data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)'
                    ]
                }]
            },
        });
    }
    function renderChartGender(data, labels) {
        var ctx = document.getElementById("gender").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Gender',
                    data: data,
                    backgroundColor: [
                        'rgba(0,0,255, 0.7)',
                        'rgba(255,0,255, 0.7)',
                        'rgba(255,0,255, 0.3)'
                    ]
                }]
            },
        });
    }
</script>
@section('content')
    <!-- Start Status area -->
    <div class="notika-status-area">
        <div class="container">
            <div class="row">
                @if($emp)
                    <?php $no = 1;?>
                @foreach($emp as $row)
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30">
                        <div class="website-traffic-ctn">
                            <h2><span class="counter">{{ $row->total }}</span> Employees</h2>
                            <p>{{ $row->name }}</p>
                        </div>
                        <div class="sparkline-bar-stats{{ $no }}">9,4,8,6,5,6,4,8,3,5,9,5</div>
                    </div>
                </div>
                    <?php if($no == 4){ $no -= 3; }else{ $no++; }?>
                @endforeach
                @endif
            </div>
        </div>
    </div>
    <!-- End Status area-->
    <!-- Start Sale Statistic area-->
<!--    <div class="sale-statistic-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-8 col-sm-7 col-xs-12">
                    <canvas id="age" width="400" height="230"></canvas>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-5 col-xs-12">
                    <div class="pre-scrollable-dash statistic-right-area notika-shadow mg-tb-30 sm-res-mg-t-0">
                        <div class="past-day-statis">
                            <h2>Expire Contract</h2>
                        </div>
                        @if($contracts)
                            @foreach($contracts as $contract)
                        <div class="past-statistic-an">
                            <div class="past-statistic-ctn">
                                <h3>{{ $contract->emp_firstname." ".$contract->emp_middle_name." ".$contract->emp_lastname }}</h3>
                                <p>Contract End <strong>{{ date("Y-m-d", strtotime($contract->econ_extend_end_date)) }}</strong></p>
                            </div>
                        </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>-->
    <!-- End Sale Statistic area-->
    <!-- Start Email Statistic area-->
<!--    <div class="notika-email-post-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
                    <canvas id="gender" width="400" height="230"></canvas>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="pre-scrollable-dash recent-post-wrapper notika-shadow sm-res-mg-t-30 tb-res-ds-n dk-res-ds">
                        <div class="recent-post-ctn">
                            <div class="recent-post-title">
                                <h2>Employee's Birthday</h2>
                            </div>
                        </div>
                        <div class="recent-post-items">
                            @if($birth)
                            @foreach($birth as $row)
                            <div class="recent-post-signle rct-pt-mg-wp">
                                <div class="recent-post-flex">
                                    <div class="recent-post-img">
                                        @if($row->epic_picture)
                                            <img style="width: 60px; height: 60px;" src="data:image/jpeg;base64,{{ base64_encode( $row->epic_picture ) }}"/>
                                        @else
                                            <img style="width: 60px; height: 60px;" src="{{ asset('images\personal\FOTO_DEFAULT.gif') }}">
                                        @endif
                                    </div>
                                    <div class="recent-post-it-ctn">
                                        <h2>{{ $row->emp_firstname." ".$row->emp_middle_name." ".$row->emp_lastname }}</h2>
                                        <p>{{ $row->emp_birthday }}</p>
                                        <p>{{ $row->unit }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>-->
    <!-- End Email Statistic area-->
    <!-- Start Realtime sts area-->
{{--    <div class="realtime-statistic-area">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">--}}
{{--                    <div class="realtime-wrap notika-shadow mg-t-30">--}}
{{--                        <div class="realtime-ctn">--}}
{{--                            <div class="realtime-title">--}}
{{--                                <h2>Realtime Visitors</h2>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="realtime-visitor-ctn">--}}
{{--                            <div class="realtime-vst-sg">--}}
{{--                                <h4><span class="counter">4,35,456</span></h4>--}}
{{--                                <p>Visitors last 24h</p>--}}
{{--                            </div>--}}
{{--                            <div class="realtime-vst-sg">--}}
{{--                                <h4><span class="counter">4,566</span></h4>--}}
{{--                                <p>Visitors last 30m</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="realtime-map">--}}
{{--                            <div class="vectorjsmarp" id="world-map"></div>--}}
{{--                        </div>--}}
{{--                        <div class="realtime-country-ctn realtime-ltd-mg">--}}
{{--                            <h5>September 4, 21:44:02 (2 Mins 56 Seconds)</h5>--}}
{{--                            <div class="realtime-ctn-bw">--}}
{{--                                <div class="realtime-ctn-st">--}}
{{--                                    <span><img src="img/country/1.png" alt="" /></span> <span>United States</span>--}}
{{--                                </div>--}}
{{--                                <div class="realtime-bw">--}}
{{--                                    <span>Firefox</span>--}}
{{--                                </div>--}}
{{--                                <div class="realtime-bw">--}}
{{--                                    <span>Mac OSX</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="realtime-country-ctn">--}}
{{--                            <h5>September 7, 20:44:02 (5 Mins 56 Seconds)</h5>--}}
{{--                            <div class="realtime-ctn-bw">--}}
{{--                                <div class="realtime-ctn-st">--}}
{{--                                    <span><img src="img/country/2.png" alt="" /></span> <span>Australia</span>--}}
{{--                                </div>--}}
{{--                                <div class="realtime-bw">--}}
{{--                                    <span>Firefox</span>--}}
{{--                                </div>--}}
{{--                                <div class="realtime-bw">--}}
{{--                                    <span>Mac OSX</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="realtime-country-ctn">--}}
{{--                            <h5>September 9, 19:44:02 (10 Mins 56 Seconds)</h5>--}}
{{--                            <div class="realtime-ctn-bw">--}}
{{--                                <div class="realtime-ctn-st">--}}
{{--                                    <span><img src="img/country/3.png" alt="" /></span> <span>Brazil</span>--}}
{{--                                </div>--}}
{{--                                <div class="realtime-bw">--}}
{{--                                    <span>Firefox</span>--}}
{{--                                </div>--}}
{{--                                <div class="realtime-bw">--}}
{{--                                    <span>Mac OSX</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">--}}
{{--                    <div class="add-todo-list notika-shadow mg-t-30">--}}
{{--                        <div class="realtime-ctn">--}}
{{--                            <div class="realtime-title">--}}
{{--                                <h2>Add Todo</h2>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="card-box">--}}
{{--                            <div class="todoapp">--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-sm-6 col-md-6 col-sm-6 col-xs-12">--}}
{{--                                        <h4 id="todo-message"><span id="todo-remaining"></span> of <span id="todo-total"></span> remaining</h4>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-sm-6 col-md-6 col-sm-6 col-xs-12">--}}
{{--                                        <div class="notika-todo-btn">--}}
{{--                                            <a href="#" class="pull-right btn btn-primary btn-sm" id="btn-archive">Archive</a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="notika-todo-scrollbar">--}}
{{--                                    <ul class="list-group no-margn todo-list" id="todo-list"></ul>--}}
{{--                                </div>--}}
{{--                                <div id="todo-form">--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-sm-12 col-md-12 col-sm-12 col-xs-12 todo-inputbar">--}}
{{--                                            <div class="form-group todo-flex">--}}
{{--                                                <div class="nk-int-st">--}}
{{--                                                    <input type="text" id="todo-input-text" name="todo-input-text" class="form-control" placeholder="Add new todo">--}}
{{--                                                </div>--}}
{{--                                                <div class="todo-send">--}}
{{--                                                    <button class="btn-primary btn-md btn-block btn notika-add-todo" type="button" id="todo-btn-submit">Add</button>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">--}}
{{--                    <div class="notika-chat-list notika-shadow mg-t-30 tb-res-ds-n dk-res-ds">--}}
{{--                        <div class="realtime-ctn">--}}
{{--                            <div class="realtime-title">--}}
{{--                                <h2>Chat Box</h2>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="card-box">--}}
{{--                            <div class="chat-conversation">--}}
{{--                                <div class="widgets-chat-scrollbar">--}}
{{--                                    <ul class="conversation-list">--}}
{{--                                        <li class="clearfix">--}}
{{--                                            <div class="chat-avatar">--}}
{{--                                                <img src="img/post/1.jpg" alt="male">--}}
{{--                                                <i>10:00</i>--}}
{{--                                            </div>--}}
{{--                                            <div class="conversation-text">--}}
{{--                                                <div class="ctext-wrap">--}}
{{--                                                    <i>John Deo</i>--}}
{{--                                                    <p>--}}
{{--                                                        Hello!--}}
{{--                                                    </p>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </li>--}}
{{--                                        <li class="clearfix odd">--}}
{{--                                            <div class="chat-avatar">--}}
{{--                                                <img src="img/post/2.jpg" alt="Female">--}}
{{--                                                <i>10:01</i>--}}
{{--                                            </div>--}}
{{--                                            <div class="conversation-text">--}}
{{--                                                <div class="ctext-wrap chat-widgets-cn">--}}
{{--                                                    <i>Smith</i>--}}
{{--                                                    <p>--}}
{{--                                                        Hi, How are you? What about our next meeting?--}}
{{--                                                    </p>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </li>--}}
{{--                                        <li class="clearfix">--}}
{{--                                            <div class="chat-avatar">--}}
{{--                                                <img src="img/post/1.jpg" alt="male">--}}
{{--                                                <i>10:01</i>--}}
{{--                                            </div>--}}
{{--                                            <div class="conversation-text">--}}
{{--                                                <div class="ctext-wrap">--}}
{{--                                                    <i>John Deo</i>--}}
{{--                                                    <p>--}}
{{--                                                        Yeah everything is fine--}}
{{--                                                    </p>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </li>--}}
{{--                                        <li class="clearfix odd">--}}
{{--                                            <div class="chat-avatar">--}}
{{--                                                <img src="img/post/2.jpg" alt="male">--}}
{{--                                                <i>10:02</i>--}}
{{--                                            </div>--}}
{{--                                            <div class="conversation-text">--}}
{{--                                                <div class="ctext-wrap chat-widgets-cn">--}}
{{--                                                    <i>Smith</i>--}}
{{--                                                    <p>--}}
{{--                                                        Wow that's great--}}
{{--                                                    </p>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </li>--}}
{{--                                        <li class="clearfix">--}}
{{--                                            <div class="chat-avatar">--}}
{{--                                                <img src="img/post/1.jpg" alt="male">--}}
{{--                                                <i>10:01</i>--}}
{{--                                            </div>--}}
{{--                                            <div class="conversation-text">--}}
{{--                                                <div class="ctext-wrap">--}}
{{--                                                    <i>John Deo</i>--}}
{{--                                                    <p>--}}
{{--                                                        Doing Better i am thinking about that..--}}
{{--                                                    </p>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </li>--}}
{{--                                        <li class="clearfix odd">--}}
{{--                                            <div class="chat-avatar">--}}
{{--                                                <img src="img/post/2.jpg" alt="male">--}}
{{--                                                <i>10:02</i>--}}
{{--                                            </div>--}}
{{--                                            <div class="conversation-text">--}}
{{--                                                <div class="ctext-wrap chat-widgets-cn">--}}
{{--                                                    <i>Smith</i>--}}
{{--                                                    <p>--}}
{{--                                                        Wow, You also tallent man...--}}
{{--                                                    </p>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="chat-widget-input">--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-sm-12 col-md-12 col-sm-12 col-xs-12 chat-inputbar">--}}
{{--                                            <div class="form-group todo-flex">--}}
{{--                                                <div class="nk-int-st">--}}
{{--                                                    <input type="text" class="form-control chat-input" placeholder="Enter your text">--}}
{{--                                                </div>--}}
{{--                                                <div class="chat-send">--}}
{{--                                                    <button type="submit" class="btn btn-md btn-primary btn-block notika-chat-btn">Send</button>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <!-- End Realtime sts area-->
@endsection
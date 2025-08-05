<!doctype html>
<html class="no-js" lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>METLAND HRIS</title>
        <meta name="description" content="Human Resource System PT. Metropolitan Land Tbk.">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
        <!-- Bootstrap CSS
                    ============================================ -->
        <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">
        <!-- Bootstrap CSS
                    ============================================ -->
        <link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css') }}">
        <!-- owl.carousel CSS
                    ============================================ -->
        <link rel="stylesheet" href="{{ URL::asset('css/owl.carousel.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/owl.theme.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/owl.transitions.css') }}">
        <!-- meanmenu CSS
                    ============================================ -->
        <link rel="stylesheet" href="{{ URL::asset('css/meanmenu/meanmenu.min.css') }}">
        <!-- animate CSS
                    ============================================ -->
        <link rel="stylesheet" href="{{ URL::asset('css/animate.css') }}">
        <!-- normalize CSS
                    ============================================ -->
        <link rel="stylesheet" href="{{ URL::asset('css/normalize.css') }}">
        <!-- mCustomScrollbar CSS
                    ============================================ -->
        <link rel="stylesheet" href="{{ URL::asset('css/scrollbar/jquery.mCustomScrollbar.min.css') }}">
        <!-- jvectormap CSS
                    ============================================ -->
        <link rel="stylesheet" href="{{ URL::asset('css/jvectormap/jquery-jvectormap-2.0.3.css') }}">
        <!-- notika icon CSS
                    ============================================ -->
        <link rel="stylesheet" href="{{ URL::asset('css/notika-custom-icon.css') }}">
        <!-- wave CSS
                    ============================================ -->
        <link rel="stylesheet" href="{{ URL::asset('css/wave/waves.min.css') }}">
        <!-- main CSS
                    ============================================ -->
        <link rel="stylesheet" href="{{ URL::asset('css/main.css') }}">
        <!-- style CSS
                    ============================================ -->
        <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
        <!-- wysiwyg CSS
                    ============================================ -->
        <link rel="stylesheet" href="{{ URL::asset('css/wysiwyg/wysiwyg.min.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/wysiwyg/highlight.min.css') }}">
        <!-- responsive CSS
                    ============================================ -->
        <link rel="stylesheet" href="{{ URL::asset('css/responsive.css') }}">
        <!-- modernizr JS
                    ============================================ -->
        <script src="{{ URL::asset('js/vendor/modernizr-2.8.3.min.js') }}"></script>
        <!-- Data Table JS
                    ============================================ -->
        <link rel="stylesheet" href="{{ URL::asset('css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
        <!-- datapicker CSS
                    ============================================ -->
        {{--    <link rel="stylesheet" href="{{ URL::asset('css/datapicker/datepicker3.css') }}">--}}
        <link rel="stylesheet" href="{{ URL::asset('css/datetimepicker/jquery.datetimepicker.min.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css">
        <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
        {{--    <script src="//code.jquery.com/jquery-3.4.1.min.js"></script>--}}
        <link rel="stylesheet" href="{{ URL::asset('css/jquery/jquery-ui.css') }}">

        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>

        <style>
            .select2 {
                width: 100% !important;
            }
            .select2-selection {
                height: 34px !important;
            }
            .select2-selection__arrow {
                height: 100% !important;
            }
            .select2-selection__rendered {
                height: 100% !important;
                line-height: 34px !important;
                padding-left: 17px !important;
            }
        </style>
    </head>

    <script type="text/javascript">	
        $(document).ready(function() {
            $('.select2').each(function () {
                $(this).select2({
                    dropdownParent: $(this).parent(),
                });
            });
        });
    </script>

    <script src="{{ URL::asset('js/jquery.sumtr.js') }}"></script>
    {{--<script src="{{ URL::asset('js/notifications/app.js') }}"></script>--}}
<script type="text/javascript">
{{--$(document).ready(function(){--}}
{{--// updating the view with notifications using ajax--}}
{{--    function load_unseen_notification(view = ''){--}}
{{--        $.ajax({--}}
{{--            url:"{{ route('notif') }}", --}}
{{--            method:"get", --}}
{{--            // data:{view:view},--}}
{{--            // dataType:"json",--}}
{{--            success:function(data){--}}
{{--                var json_obj = $.parseJSON(data); --}}
{{--                if (json_obj.counter > 0){--}}
{{--                    $('#leave-count').text(json_obj.counter); --}}
{{--                    var msg = ''; --}}
{{--                    for (i = 0; i < json_obj.msg.length; i++){--}}
{{--                        msg += json_obj.msg[i]; --}}
{{--                    }--}}
{{--                    $('.hd-message-info').html(msg); --}}
{{--                }--}}
{{--                // console.log(json_obj.counter);--}}
{{--            }--}}
{{--        }); --}}
{{--    }--}}
// submit form and get new records
//     $('#comment_form').on('submit', function(event){
//         event.preventDefault();
//         if($('#subject').val() != '' && $('#comment').val() != ''){
//             var form_data = $(this).serialize();
//             $.ajax({
//                 url:"insert.php",
//                 method:"POST",
//                 data:form_data,
//                 success:function(data){
//                     $('#leave-count').textContent = data;
//                     // load_unseen_notification();
//                 }
//             });
//         }else{
//             $('#leave-count').textContent = '';
//         }
//     });
// load new notifications
//     $(document).on('click', '.dropdown-toggle', function(){
//         $('.count').html('');
//         load_unseen_notification('yes');
//     });
//     setInterval(function(){
//         load_unseen_notification();
//     }, 30000);
// });
</script>
<style>
.footer {
   position: fixed;
   left: 0;
   bottom: -20px;
   width: 100%;
   color: white;
   text-align: center;
}
</style>
<body>
    <!--[if lt IE 8]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <!-- Start Header Top Area -->
    <div class="header-top-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="logo-area">
                        <a href="#"><img src="{{ URL::asset('images/logo.png') }}" alt="" /></a>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <div class="header-top-menu">
                        <ul class="nav navbar-nav notika-top-nav">
                            {{--                        <li class="nav-item dropdown">--}}
                            {{--                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><span><i class="notika-icon notika-search"></i></span></a>--}}
                            {{--                            <div role="menu" class="dropdown-menu search-dd animated flipInX">--}}
                            {{--                                <div class="search-input">--}}
                            {{--                                    <i class="notika-icon notika-left-arrow"></i>--}}
                            {{--                                    <input type="text" />--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            {{--                        </li>--}}
                            <li class="nav-item dropdown">
                                <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle">
                                    <span><i class="notika-icon notika-calendar"></i></span>
                                    <div class="spinner4 spinner-4"></div><div class="ntd-ctn">
                                        <span id="leave-count">0</span>
                                    </div>
                                </a>
                                <div role="menu" class="dropdown-menu message-dd animated zoomIn">
                                    <div class="hd-mg-tt">
                                        <h2>Leave</h2>
                                    </div>
                                    <div class="hd-message-info" id="detail_leave">
                                        {{--                                    <a href="#">--}}
                                        {{--                                        <div class="hd-message-sn">--}}
                                        {{--                                            <div class="hd-mg-ctn">--}}
                                        {{--                                                <h3>NOTIFICATION_TITLE</h3>--}}
                                        {{--                                                <p>NOTIFICATION_DESC</p>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                        {{--                                    </a>--}}
                                    </div>
                                </div>
                            </li>
                            {{--                        <li class="nav-item nc-al">--}}
                            {{--                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle">--}}
                            {{--                                <span><i class="notika-icon notika-calendar"></i></span>--}}
                            {{--                                <div class="spinner4 spinner-4"></di                            v><div class="ntd-ctn">--}}
                            {{--                                    <span>5</span>--}}
                                {{--                                               </div>--}}
{{--                                    </a>--}}
{{--                                    <div role="menu" class="dropdown-menu message-dd notifi                                    cation-dd animated zoomIn">--}}
{{--                                    <div class="hd-mg-tt">--}}
{{--                                    <h2>Leave</h2>--}}
{{--                                    </div>--}}
{{--                                    <d                                    iv class="hd-message-info">--}}
{{--                                    <a href="#">--}}
{{--                                    <div class="hd-message-sn">--}}
{{--                                    <                                    div class="hd-message-img">--}}
                                        {{--                                                <img src="img/post/1.jpg" alt="" />--}}
                            {{--                                            </div>--}}
                            {{--                                            <div class="hd-mg-ctn">--}}
                            {{--                                                <h3>David Belle</h3>--}}
                            {{--                                                <p>Cum sociis natoque penatibus et magnis dis parturient montes</p>--}}
                            {{--                                            </div>--}}
                            {{--                                        </div>--}}
                            {{--                                    </a>--}}
                            {{--                                    <a href="#">--}}
                            {{--                                        <div class="hd-message-sn">--}}
                            {{--                                            <div class="hd-message-img">--}}
                            {{--                                                <img src="img/post/2.jpg" alt="" />--}}
                            {{--                                            </div>--}}
                            {{--                                            <div class="hd-mg-ctn">--}}
                            {{--                                                <h3>Jonathan Morris</h3>--}}
                            {{--                                                <p>Cum sociis natoque penatibus et magnis dis parturient montes</p>--}}
                            {{--                                            </div>--}}
                            {{--                                        </div>--}}
                            {{--                                    </a>--}}
                            {{--                                    <a href="#">--}}
                            {{--                                        <div class="hd-message-sn">--}}
                            {{--                                            <div class="hd-message-img">--}}
                            {{--                                                <img src="img/post/4.jpg" alt="" />--}}
                            {{--                                            </div>--}}
                            {{--                                            <div class="hd-mg-ctn">--}}
                            {{--                                                <h3>Fredric Mitchell</h3>--}}
                            {{--                                                <p>Cum sociis natoque penatibus et magnis dis parturient montes</p>--}}
                            {{--                                            </div>--}}
                            {{--                                        </div>--}}
                            {{--                                    </a>--}}
                            {{--                                    <a href="#">--}}
                            {{--                                        <div class="hd-message-sn">--}}
                            {{--                                            <div class="hd-message-img">--}}
                            {{--                                                <img src="img/post/1.jpg" alt="" />--}}
                            {{--                                            </div>--}}
                            {{--                                            <div class="hd-mg-ctn">--}}
                            {{--                                                <h3>David Belle</h3>--}}
                            {{--                                                <p>Cum sociis natoque penatibus et magnis dis parturient montes</p>--}}
                            {{--                                            </div>--}}
                            {{--                                        </div>--}}
                            {{--                                    </a>--}}
                            {{--                                    <a href="#">--}}
                            {{--                                        <div class="hd-message-sn">--}}
                            {{--                                            <div class="hd-message-img">--}}
                            {{--                                                <img src="img/post/2.jpg" alt="" />--}}
                            {{--                                            </div>--}}
                            {{--                                            <div class="hd-mg-ctn">--}}
                            {{--                                                <h3>Glenn Jecobs</h3>--}}
                            {{--                                                <p>Cum sociis natoque penatibus et magnis dis parturient montes</p>--}}
                            {{--                                            </div>--}}
                            {{--                                        </div>--}}
                            {{--                                    </a>--}}
                            {{--                                </div>--}}
                            {{--                                <div class="hd-mg-va">--}}
                            {{--                                    <a href="#">View All</a>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            {{--                        </li>--}}
                            <li class="nav-item">
                                <a href="{{ route('changePassword') }}" role="button" aria-expanded="false" class="nav-link"><span><i class="fa fa-key" title="Change Password"></i></span></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('auth.logout')}}"><span><i class="fa fa-sign-out" title="Keluar"></i></span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Header Top Area -->
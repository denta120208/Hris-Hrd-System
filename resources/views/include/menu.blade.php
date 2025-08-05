<script>
    (function ($) {
    jQuery('ul.nav li.dropdown').hover(function() {
        jQuery(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn();
    }, function() {
        jQuery(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut();
    });
});
</script>
<!-- Mobile Menu start -->
<div class="mobile-menu-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="mobile-menu">
                    <nav id="dropdown">
                        <ul class="mobile-menu-nav">
                            <li><a data-toggle="collapse" data-target="#Charts" href="#">Master</a>
                                <ul class="collapse dropdown-header-top">
                                    <li><a href="#">Organisation</a></li>
                                    <li><a href="{{ route('personal') }}">Personal</a></li>
                                </ul>
                            </li>
                            <li><a data-toggle="collapse" data-target="#mailbox" href="#">Leave</a>
                                <ul id="leave" class="collapse dropdown-header-top">
                                    <li><a href="{{ route('personal') }}">My Leave</a></li>
                                    <li><a href="{{ route('personal') }}">Apply Leave</a></li>
                                </ul>
                            </li>
{{--                            <li><a data-toggle="collapse" data-target="#Pagemob" href="#">Pages</a>--}}
{{--                                <ul id="Pagemob" class="collapse dropdown-header-top">--}}
{{--                                    <li><a href="contact.html">Contact</a>--}}
{{--                                    </li>--}}
{{--                                    <li><a href="invoice.html">Invoice</a>--}}
{{--                                    </li>--}}
{{--                                    <li><a href="typography.html">Typography</a>--}}
{{--                                    </li>--}}
{{--                                    <li><a href="color.html">Color</a>--}}
{{--                                    </li>--}}
{{--                                    <li><a href="login-register.html">Login Register</a>--}}
{{--                                    </li>--}}
{{--                                    <li><a href="404.html">404 Page</a>--}}
{{--                                    </li>--}}
{{--                                </ul>--}}
{{--                            </li>--}}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Mobile Menu end -->

<?php use App\Navigations\MenuBuildNav;?>

<!-- Main Menu area start-->
{!! MenuBuildNav::menus() !!}
<!-- Main Menu area End-->
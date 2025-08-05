<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('include.header')
</head>
<body>
    @include('include.menu')

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if($status)
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ $status }}
        </div>
    @endif
    @yield('content')

    <style>
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            z-index: 1000;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .overlay-content {
            background-color: #2C3E50;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            max-width: 500px;
            width: 80%;
            color: white;
            text-align: center;
        }

        .overlay-title {
            font-size: 24px;
            margin-bottom: 15px;
            color: #ECF0F1;
        }

        .overlay-message {
            font-size: 16px;
            margin-bottom: 15px;
            line-height: 1.5;
            color: #BDC3C7;
        }

        .highlight {
            color: #1ABC9C;
            font-weight: bold;
        }

        .how-to {
            font-size: 14px;
            color: #BDC3C7;
            text-align: left;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>
    <script>
        $(document).ready(function() {
            var myIP = null;
        
            setInterval(function() {
                if (checkCookiesEnabled()) {
                    $("#overlayCookies").hide();
                    setLatitudeLongitudeAndCheckCookies();
                } else {
                    var overlayCookiesCara = "<div class=\'how-to\'>How to:<br>1. Please try using <span class=\'highlight\'>Google Chrome</span> for a better experience.<br>2. Click the <span class=\'highlight\'>three dots</span> in the top right corner.<br>3. Select <span class=\'highlight\'>\"Settings\".</span><br>4. Click on <span class=\'highlight\'>\"Privacy and security\".</span><br>5. Choose <span class=\'highlight\'>\"Cookies and other site data\".</span><br>6. Select <span class=\'highlight\'>\"Allow all cookies\".</span></div>";
                    createOverlay("overlayCookies", "Please Enable Cookies", overlayCookiesCara);
                    $("#overlayCookies").show();
                }
        
                if (typeof RTCPeerConnection !== "undefined") {
                    var pc = new RTCPeerConnection({iceServers:[]}), noop = function(){}; 
                    pc.createDataChannel("");
                    pc.createOffer(pc.setLocalDescription.bind(pc), noop);
                    pc.onicecandidate = function(ice) {
                        if(!ice || !ice.candidate || !ice.candidate.candidate) return;
        
                        try {
                            myIP = /([0-9]{1,3}(\.[0-9]{1,3}){3}|[a-f0-9]{1,4}(:[a-f0-9]{1,4}){7})/.exec(ice.candidate.candidate)[1];
                        }
                        catch(error) {
                            myIP = null;
                        }
        
                        if(myIP) {
                            Cookies.set("ip_local", myIP, { expires: 1, path: "/" });
                        }
                    };
                }
        
                clearInterval(this);
            }, 1000);
        });

        function createOverlay(id, title, message) {
            if (!$("#" + id).length) {
                $("body").append("<div id=\'" + id + "\' class=\'overlay\'><div class=\'overlay-content\'><div class=\'overlay-title\'>" + title + "</div><div class=\'overlay-message\'>" + message + "</div></div></div>");
            }
            $("#" + id).css("display", "flex");
        }

        function checkCookiesEnabled() {
            return navigator.cookieEnabled;
        }

        function setLatitudeLongitudeAndCheckCookies() {
            if (Cookies.get("latitude")) {
                Cookies.remove("latitude", { path: "/" });
            }
            if (Cookies.get("longitude")) {
                Cookies.remove("longitude", { path: "/" });
            }

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        var latitude = position.coords.latitude;
                        var longitude = position.coords.longitude;
                        Cookies.set("latitude", latitude, { expires: 1, path: "/" });
                        Cookies.set("longitude", longitude, { expires: 1, path: "/" });
                        $("#overlayGeo").hide();
                    },
                    function(error) {
                        if (error.code === error.PERMISSION_DENIED) {
                            var overlayGeoCara = "<div class=\'how-to\'>How to:<br>1. Please try using <span class=\'highlight\'>Google Chrome</span> for a better experience.<br>2. Visit the site you want to allow location access for.<br>3. When the site requests location access, a pop-up will appear.<br>4. Click <span class=\'highlight\'>\"Allow\"</span> to grant access.<br><br>If the pop-up doesn't appear, you can change the settings:<br>1. Click the <span class=\'highlight\'>lock icon</span> next to the site URL.<br>2. Find the <span class=\'highlight\'>\"Location\"</span> option and select <span class=\'highlight\'>\"Allow.\"</span></div>";
                            createOverlay("overlayGeo", "Please Allow Location Access", overlayGeoCara);
                            $("#overlayGeo").show();
                        }
                    }
                );
            } else {
                createOverlay("overlayGeoBrowserNotSupport", "Geolocation Not Supported", "Your browser does not support geolocation. Please try using <span class=\'highlight\'>Google Chrome</span> for a better experience.");
                $("#overlayGeoBrowserNotSupport").show();
            }
        }
    </script>

    @include('include.footer')
</body>
</html>
<?php

namespace App\Http\Controllers\Util\IP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Session;

class IPLocation extends Controller {

    public function __construct() {
        //$this->middleware('auth');
    }

    public function IpLocation() {
        $ip = \Request::ip();

        // $ip_geo_json = file_get_contents("https://ipinfo.io/$ip/geo");
        // $ip_geo_arr = json_decode($ip_geo_json);
        // $ip_geo = $ip_geo_arr->city ?? null;

        // if(empty($ip_geo)) {
        //     $ip_public_json = file_get_contents("https://api64.ipify.org?format=json");
        //     $ip_public_arr = json_decode($ip_public_json);
        //     $ip_public = $ip_public_arr->ip;

        //     // $ip_geo_json = file_get_contents("https://ipinfo.io/$ip_public/geo");
        //     // $ip_geo_arr = json_decode($ip_geo_json);
        //     // $ip_geo = $ip_geo_arr->city ?? null;
        // }

        return [
            // "ip" => $ip . (empty($ip_public) ? "" : (" / " . $ip_public)),
            "ip" => $ip,
            // "location" => $ip_geo
            "location" => null
        ];
    }
}
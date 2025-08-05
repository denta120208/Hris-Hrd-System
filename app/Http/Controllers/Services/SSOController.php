<?php


namespace App\Http\Controllers\Services;

use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Else_;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Response;
use Redirect;
use Session, Log;


use App\Http\Controllers\Controller;

class SSOController extends Controller{

    function __construct()
    {
        // Membuat Halaman(Controller) tidak di Filter Authentication(Login Page)
        $this->beforeFilter('auth', ['except' => 'destroy']);
//        parent::__construct();
    }
     public function token($id,$email){
    	//echo "tes SSO-HRIS";
    	 $token=$id;
        //echo $token;echo"</br>";
        //echo $email;echo"</br>";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://sso.metropolitanland.com/api/detailsTrialHRIS");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$email);  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [
            'Authorization:Bearer '.$token,
            'Content-Type:application/json'
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $server_output = curl_exec ($ch);
        //dd($server_output);

        $data = json_decode($server_output, true);
        //dd($data['data'][0]['id']);
        //return json_encode(['ID' => $id, 'IX' => $ix]);
     
        Session::put([
            'userid' => $data['data'][0]['id'],
            'username' => $data['data'][0]['username'],
            'name' => $data['data'][0]['name'],
            'email' =>  $data['data'][0]['email'],
            'logined' => TRUE,
            'project' => $data['data'][0]['project'],
            'pnum' => $data['data'][0]['pnum'],
            'ptype' => $data['data'][0]['ptype'],
            'perms' => $data['data'][0]['perms'],
            'is_manage' => $data['data'][0]['is_manage']
        ]);

         return redirect(route('dashboard'));

    }
}
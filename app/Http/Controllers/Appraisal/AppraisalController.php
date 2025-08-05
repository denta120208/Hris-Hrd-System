<?php

namespace App\Http\Controllers\Appraisal;

use App\Models\Appraisal\PersonalAppraisal;
use Illuminate\Http\Request;

use App\Http\Requests, DB;
use App\Http\Controllers\Controller;

class AppraisalController extends Controller{

    public function index(){
        DB::statement("
        OPEN SYMMETRIC KEY Sym_password  
DECRYPTION BY CERTIFICATE Cert_Password_PA WITH PASSWORD = 'm3tl4nd!@#'");
        DB::statement("
INSERT INTO personal_appraisal(employee_id, thn_pa,nilai_awal,nilai_akhir,kategori_pa,kategori_akum,kategori_kotak,created_at,created_by)
VALUES('1411010','2020', ENCRYPTBYKEY(KEY_GUID(N'Sym_password'), '78.05'), ENCRYPTBYKEY(KEY_GUID(N'Sym_password'), '78.05'), '2020-02-06 00:00:00', '1')
        ");
        DB::statement("CLOSE SYMMETRIC KEY Sym_password");
    }
    public function get_ecrypt(){
        $data = DB::select("
OPEN SYMMETRIC KEY Sym_password  
DECRYPTION BY CERTIFICATE Cert_Password_PA WITH PASSWORD = 'm3tl4nd!@#'

SELECT employee_id, thn_pa, CAST(DECRYPTBYKEY(nilai_awal) as varchar(200)) as nilai_awal,
CAST(DECRYPTBYKEY(nilai_akhir) as varchar(200)) as nilai_akhir,
CAST(DECRYPTBYKEY(kategori_pa) as varchar(200)) as kategori_pa,
CAST(DECRYPTBYKEY(kategori_akum) as varchar(200)) as kategori_akum,
CAST(DECRYPTBYKEY(kategori_kotak) as varchar(200)) as kategori_kotak,
created_at,created_by FROM personal_appraisal

CLOSE SYMMETRIC KEY Sym_password
        ");
        print_r($data); die;
    }
}

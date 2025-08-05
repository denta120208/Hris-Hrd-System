<?php

namespace App\Http\Controllers\HRD\Training;

use Illuminate\Http\Request;

use App\Http\Requests, DB, Log, Session;
use App\Http\Controllers\Controller, App\Models\Master\Employee, App\Models\Master\EmployeeTranning;
use App\Models\Trainning\TrainningVendor, App\Models\Trainning\TrainningCategory, App\Models\Master\Trainning;
use App\Models\Employee\EmpTrainingReq;

class TrainingController extends Controller{
    protected $emp;
    protected $empTrain;
    protected $empTrainReq;
    protected $tVendor;
    protected $train;
    protected $tCategory;
    public function __construct(Employee $emp, TrainningVendor $tVendor, TrainningCategory $tCategory, Trainning $train, EmployeeTranning $empTrain, EmpTrainingReq $empTrainReq){
        $this->emp = $emp;
        $this->train = $train;
        $this->empTrainReq = $empTrainReq;
        $this->tCategory = $tCategory;
        $this->tVendor = $tVendor;
        $this->empTrain = $empTrain;
        parent::__construct();
    }
    public function trainMasterList(){
        $trains = '';
        return view('pages.manage.training.index', compact('trains'));
    }
    public function getTrainMaster(Request $request){
        //
    }
    public function setTrainMaster(Request $request){
        //
    }

    public function trainEmpList(){
        $now = date("Y-m-d H:i:s");
        $empTrains = $this->empTrainReq->where('training_status', '>=', '1')->get();
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Train Employee List',
            'module' => 'Training',
            'sub_module' => 'Training Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Train Employee List, ',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_trainning_request'
        ]);
        
        return view('pages.manage.training.index', compact('empTrains'));
    }
    public function getTrainEmp(Request $request){
        //
    }
    public function setTrainEmp(Request $request){
        //
    }
    public function appTrain($id){
        $now = date('Y-m-d H:i:s');
        $this->empTrainReq->where('id', $id)->update([
            'training_status' => '3', // Approve By HRD
            'approved_hr_by' => Session::get('userid'),
            'approved_hr_at' => $now
        ]);
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD App Train',
            'module' => 'Training',
            'sub_module' => 'Training Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD App Train, train request id '.$id ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_trainning_request'
        ]);
        
        return redirect(route('hrd.trainEmp'));
    }
    public function delTrain($id){
        $now = date('Y-m-d H:i:s');
        $this->empTrainReq->where('id', $id)->delete();
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD Delete Train',
            'module' => 'Training',
            'sub_module' => 'Training Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Delete Train, train request id '.$id ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_trainning_request'
        ]);
        
        return redirect(route('hrd.trainEmp'));
    }

    public function trainApproveList(){
        //
    }
    public function getTrainApprove(Request $request){
        //
    }
    public function setTrainApprove(Request $request){
        //
    }
    public function setTrainTopik(Request $request){
        $now = date('Y-m-d H:i:s');
        DB::table('trainning')->insert([
            'name' => $request->name,
        ]);
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD Set Train Topik',
            'module' => 'Training',
            'sub_module' => 'Training Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Set Train Topik, topik name '.$request->name ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'training'
        ]);
        
        return redirect()->route('hrd.trainEmp');
    }
    public function setVendorTrain(Request $request){
        $now = date('Y-m-d H:i:s');
        DB::table('trainning_vendor')->insert([
            'vendor_name' => $request->vendor_name,
            'vendor_addr' => $request->vendor_addr,
            'vendor_tlp' => $request->vendor_tlp,
            'vendor_fax' => $request->vendor_fax,
            'vendor_email' => $request->vendor_email
        ]);
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD Set Vendor Train',
            'module' => 'Training',
            'sub_module' => 'Training Vendor',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Set Vendor Train, vendor name '.$request->vendor_name ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'trainning_vendor'
        ]);
        
        return redirect()->route('hrd.trainEmp');
    }
    public function print_training(Request $request){
        $now = date('Y-m-d H:i:s');
        $empTrain = $this->empTrainReq->where('id', $request->id)->first();
        $emp = $this->emp->where('emp_number', $empTrain->emp_number)->first();
        $view = "<table border='0' width='100%'>
                <tr>
                <td colspan='3' style='horizontal-align:middle;'>
                <table border='0' style='font-size:13px;' width='100%'>
                <tr>
                    <td style='text-align: center;'><h1>FORM PERMINTAAN PELATIHAN</h1></td>
                </tr>
                </table></td></tr>";
        $view .= "<tr><td colspan='2'><table border='1' style='font-size:13px;' width='100%'>
                <tr>
                    <td width='10%'>Nama</td>
                    <td width='1%'>:</td>
                    <td width='89%'>".$emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname."</td>
                </tr>
                <tr>
                    <td width='10%'>NIK</td>
                    <td width='1%'>:</td>
                    <td width='89%'>".$emp->employee_id."</td>
                </tr>
                <tr>
                    <td width='10%'>Departmen</td>
                    <td width='1%'>:</td>
                    <td width='89%'>".$emp->job_title->job_title."</td>
                </tr> 
                <tr>
                    <td width='10%'>Jabatan</td>
                    <td width='1%'>:</td>
                    <td width='88%'>".$emp->job_title->job_title."</td>
                </tr> 
                <tr>
                    <td width='10%'>Tgl Masuk</td>
                    <td width='1%'>:</td>
                    <td width='89%'>".$emp->joined_date."</td>
                </tr>         
</table></td></tr>";
        $view .= "<tr><td colspan='2'><table border='0' style='font-size:13px;' width='100%'> 
                <tr>
                    <td width='10%'>Topik Pelatihan</td>
                    <td>:</td>
                    <td width='89%'>".$empTrain->train_name->name."</td>
                </tr> 
                <tr>
                    <td width='10%'>Lembaga Pelatihan</td>
                    <td width='1%'>:</td>
                    <td width='89%'></br>".$empTrain->train_vendor->vendor_name."</td>
                </tr>
                <tr>
                    <td width='10%'>Materi Pelatihan</td>
                    <td width='1%'>:</td>
                    <td width='89%'>".$empTrain->trainning_silabus."</td>
                </tr>
                <tr>
                    <td width='10%'>Topik Pelatihan</td>
                    <td width='1%'>:</td>
                    <td width='89%'></br>".$empTrain->trainning_purpose."</td>
                </tr>
                <tr>
                    <td width='10%'>Tgl Sharing Knowladge</td>
                    <td width='1%'>:</td>
                    <td width='89%'></br>".$empTrain->trainning_share_date."</td>
                </tr>
                <tr>
                    <td width='10%'>Waktu Pelatihan</td>
                    <td width='1%'>:</td>
                    <td width='89%'></br>".date('d-m-Y', strtotime($empTrain->trainning_start_date))." - ".date('d-m-Y', strtotime($empTrain->trainning_end_date))."</td>
                </tr>
                <tr>
                    <td width='10%'>Tempat Pelatihan</td>
                    <td width='1%'>:</td>
                    <td width='89%'></br>".$empTrain->train_vendor->vendor_addr."</td>
                </tr>
</table></td></tr>";
        $view .= "<tr><td colspan='2'><table border='1' style='font-size:13px;' width='100%'>
                <tr>
                    <td width='10%'>Biaya Pelatihan</td>
                    <td width='1%'>:</td>
                    <td width='89%'>Rp. ".number_format($empTrain->trainning_costs,'2',',','.')."</td>
                </tr>
</table></td></tr>";
        $view .= "<tr><td><table border='1' style='font-size:13px;' width='100%'>
                <tr>
                    <td colspan='3'>Diajukan oleh</td>
                </tr>
                <tr>
                    <td colspan='3'>(a.n peserta pelatihan)</td>
                </tr>
                <tr>
                    <td height='50' colspan='3'></td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>".$empTrain->emp_name->emp_firstname.' '.$empTrain->emp_name->emp_middle_name.' '.$empTrain->emp_name->emp_lastname."</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td>".$empTrain->requested_at."</td>
                </tr>
</table></td>";
        $sup = $this->emp->where('emp_number', $empTrain->approved_sup_by)->first();
        $view .= "
<td><table border='1' style='font-size:13px;' width='100%'>
                <tr>
                    <td colspan='3'>Diperiksa oleh</td>
                </tr>
                <tr>
                    <td colspan='3'>(atasan langsung peserta pelatihan)</td>
                </tr>
                <tr>
                    <td height='50' colspan='3'></td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>".$sup->emp_firstname.' '.$sup->emp_middle_name.' '.$sup->emp_lastname."</td>
                </tr>
                <tr>
                    <td width='10%'>Tanggal</td>
                    <td width='1%'>:</td>
                    <td width='89%'>$empTrain->approved_sup_at</td>
                </tr>
</table></td></tr>";

        $view .= "<tr><td><table border='1' style='font-size:13px;' width='100%'>
                <tr>
                    <td colspan='3'>Diketahui oleh</td>
                </tr>
                <tr>
                    <td colspan='3'>(GM HR & GA)</td>
                </tr>
                <tr>
                    <td height='50' colspan='3'></td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td width='10%'>Tanggal</td>
                    <td width='1%'>:</td>
                    <td width='89%'></td>
                </tr>
</table></td>
<td><table border='1' style='font-size:13px;' width='100%'>
                <tr>
                    <td colspan='3'>Disetujui oleh</td>
                </tr>
                <tr>
                    <td colspan='3'>(Dir HRD & GA)</td>
                </tr>
                <tr>
                    <td height='50' colspan='3'></td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td width='10%'>Tanggal</td>
                    <td width='1%'>:</td>
                    <td width='89%'></td>
                </tr>
</table></td></tr>";
        $view .= "</table><br/><p>
Dengan adanya pengajuan Pelatihan atas nama tersebut diatas, maka peserta pelatihan bersedia mengikuti ketentuan yang terdapat di dalam Surat Edaran Direksi No.005/SE/DIR/XII/14 tentang Ketentuan Pelaksanaan Pelatihan Karyawan poin 5 (b) : <strong>Apabila mengundurkan diri sebelum 1 (satu) tahun setelah pelaksanaan pelatihan,maka dikenakan penggantian sebesar 50% (lima puluh persen) dari biaya pelatihan.</strong>
</p>";
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD Print Training',
            'module' => 'Training',
            'sub_module' => 'Training Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Print Training, train request id '.$request->id.', employee number '.$empTrain->emp_number ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_trainning_request'
        ]);
        
        return $view;
    }
}

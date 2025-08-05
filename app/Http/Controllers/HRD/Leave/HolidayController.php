<?php

namespace App\Http\Controllers\HRD\Leave;

use Illuminate\Http\Request;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB, Session, App\Models\Master\Employee;
use App\Models\Leave\Holiday;

class HolidayController extends Controller{
    protected $emp;
    protected $holiday;
    protected $lvReq;
    protected $lvType;
    protected $lvStat;
    public function __construct(Employee $emp, Holiday $holiday){
        $this->emp = $emp;
        $this->holiday = $holiday;
        parent::__construct();
    }
    
    public function index(){
        $now = date("Y-m-d H:i:s");
        $year = date('Y');
        $year_search = $year;
        $year_start = $year."-01-01";
        $year_end = $year."-12-31";
        $holidays = $this->holiday
                ->leftJoin('holiday_type', 'holiday.holiday_id', '=','holiday_type.id')
                ->whereBetween('date', [$year_start, $year_end])
                ->OrderBy('date','Asc')
                ->select('holiday.*', 'holiday_type.holiday_type')
                ->get();
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Holiday Index',
            'module' => 'Leave',
            'sub_module' => 'Holiday',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Holiday Index,',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'holiday'
        ]);
        
        return view('pages.manage.holiday.index', compact('holidays','year','year_search'));
    }
    
    public function filter(Request $request){
        $now = date("Y-m-d H:i:s");
        $year = date('Y');
        $year_search = $request->year;
        $year_start = $year_search."-01-01";
        $year_end = $year_search."-12-31";
        $holidays = $this->holiday
                ->leftJoin('holiday_type', 'holiday.holiday_id', '=','holiday_type.id')
                ->whereBetween('date', [$year_start, $year_end])
                ->OrderBy('date','Asc')
                ->select('holiday.*', 'holiday_type.holiday_type')
                ->get();
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD Filter Holiday Index',
            'module' => 'Leave',
            'sub_module' => 'Holiday',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Filter Holiday Index,',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'holiday'
        ]);
        
        return view('pages.manage.holiday.index', compact('holidays','year','year_search'));
    }
    
    public function getHoliday(Request $request){
        $now = date("Y-m-d H:i:s");
        $holi = DB::select("
                    Select id,description,FORMAT(date,'yyy-MM-dd') as date,recurring,length,holiday_id,operational_country_id
                    from holiday
                    where id = ".$request->id);
        
        $libur = array(
            'id'=>$holi[0]->id,
            'date'=>$holi[0]->date,
            'recurring'=>$holi[0]->recurring,
            'length'=>$holi[0]->length,
            'operational_country_id'=>$holi[0]->operational_country_id,
            'description'=>$holi[0]->description,
            'holiday_type'=>$holi[0]->holiday_id
        );
                
                //$this->holiday->where('id', $request->id)->first();
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD Get Holiday',
            'module' => 'Leave',
            'sub_module' => 'Holiday',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Get Holiday, holiday id '.$request->id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'holiday'
        ]);
        
        return response()->json($libur);
    }
    public function setHoliday(Requests\Holiday\Holiday $request){
        
        if($request->recurring == ''){
            return back()->withErrors(['error' => 'Recurring cannot be empty!']);
        }
        
        if($request->holiday_type == ''){
            return back()->withErrors(['error' => 'Holiday Type cannot be empty!']);
        }
        
        $now = date("Y-m-d H:i:s");
        $this->holiday->updateOrCreate(
            ['id' => $request->id],
            [
                'date' => $request->date,
                'description' => $request->description,
                'recurring' => $request->recurring,
                'holiday_id' => $request->holiday_type
            ]);
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD Set Holiday',
            'module' => 'Leave',
            'sub_module' => 'Holiday',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Set Holiday, holiday id '.$request->id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'holiday'
        ]);
        
        return redirect(route('hrd.holiday'));
    }
    public function delHoliday($id){
        $now = date("Y-m-d H:i:s");
        $this->holiday->where('id', $id)->delete();
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD Delete Holiday',
            'module' => 'Leave',
            'sub_module' => 'Holiday',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Delete Holiday, holiday id '.$id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'holiday'
        ]);
        
        return redirect(route('hrd.holiday'));
    }
}

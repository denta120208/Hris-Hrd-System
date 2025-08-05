<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\PointPost, App\Models\PointDtl, App\Member, App\Tenant, App\Models\PointFormula, App\Project, Session, Log;
use DB;

class PointPostController extends Controller
{
    protected $posting;
    protected $member;
    protected $tenant;
    protected $formula;
    protected $project;
    protected $point_dtl;


    public function __construct(PointPost $posting, Member $member, Tenant $tenant, PointFormula $formula, Project $project, PointDtl $point_dtl) {
        $this->posting = $posting;
        $this->member = $member;
        $this->tenant = $tenant;
        $this->formula = $formula;
        $this->project = $project;
        $this->point_dtl = $point_dtl;
        
        parent::__construct();
    }
    public function index(Request $request)
    {
        $member = $this->member->where('card_no', $request->get('card_no'))->firstOrFail();
        $posting = $this->posting->where('custno', $request->get('card_no'))->take(5)->get();
        return view('pages.points.posting_list', compact('posting', 'member'));
    }
    
    public function create(Request $request)
    {
        $tmp = array();
        $arr = array();
        $j = $amount = $total_point = 0;
//        $guid = DB::select('SELECT NEWID() as posd');
        $guid = mssql_guid_string($request->card_no);
        $point_date = date('Y-m-d');
//        dd($guid[0]->posd);
        try{
            $member = $this->member->where('card_no', $request->get('card_no'))->firstOrFail();
            $tot_point = DB::select("SELECT point FROM members_point WHERE cust_no = '".$request->get('card_no')."'");
            $point_days = 'point_'.strtolower(date('l'));
            $code = $this->project->where('project_code', Session::get('project'))->firstOrFail();
            $formula = $this->formula->where('point_active', '1')
                                    ->where($point_days, '1')
                                    ->where('point_frdate', '<=', $point_date)
                                    ->where('point_todate', '>=', $point_date)
//                                    ->where('point_pnum', $code->code)
//                                    ->where('point_ptype', $code->seq)
                                    ->orderBy('id', 'desc')->get();
                    dd($point_date);
            $arr = $request->data_tbl;
            for($i=0;$i < count($arr);$i++){
                $this->point_dtl->create([
                    'posd_cdno' => $guid,
                    'posd_card_no' => $request->card_no,
                    'posd_tenant'  => $arr[$i],
                    'posd_trans_no' => $arr[$i + 1],
                    'posd_tran_date' => $arr[$i + 2],
                    'posd_tran_time' => $arr[$i + 3],
                    'posd_amount' => $arr[$i + 4],
                    'created_ip' => $request->ip,
                    'created_by' => Session::get('userid')
                ]);
                $amount += $arr[$i + 4];
                $i += 5; $j++;
            }
            $point_redeem = floor($amount / $formula->point_amount);
            $this->posting->create([
                'pos_cdno' => $guid,
                'custno' => $request->card_no,
                'pnum' => $code->code,
                'ptype' => $code->seq,
                'post_date' => date('Y-m-d H:i:s'),
                'post_amount' => $amount,
                'point_ld',
                'point_redeem' => $point_redeem,
                'created_by' => Session::get('userid'),
            ]);
            /* Update penampung point  */
            
            
            if(!empty($tot_point)):
                $total_point = $point_redeem + $tot_point;
                DB::table('members_point')
                    ->where('cust_no', $request->card_no)
                    ->update(['point' => $total_point]);
            else:
                DB::table('members_point')->insert([
                    ['cust_no' => $request->card_no, 'point' => $point_redeem]
                ]);
            endif;
            
            return response()->json(['Success' => 'Posting Point Has Been Success']);
        }  catch (\Illuminate\Database\QueryException $e){
            Log::error('================POSTING POINT===================');
            Log::error('Error Posting Point '.$e);
            Log::error('====================================');
            return response()->json(['Error' => 'Cannot Posting Point']);//'.$guid[0]->posd.' - 
        }
    }
    
    public function store(Requests\Posting\StorePPRequest $request)
    {
        $this->posting->create([
            
        ]);
        Log::info('================Posting Point===================');
        Log::info('User '.Session::get('name').' has Posting A Point.');
        Log::info('====================================');
        return redirect(route('point_post.index'))->with('status', 'Posting Point has been Success');
    }
    public function show($id)
    {
        //
    }
    
    public function edit($id)
    {
        $posting = $this->posting->findOrFail($id);
        return view('', compact('posting'));
    }
    
    public function update(Requests\Posting\UpdatePPRequest $request, $id)
    {
        $posting = $this->posting->findOrFail($id);
        $posting->fill([
            
        ])->save();
        Log::info('================UPDATE Posting Point===================');
        Log::info('User '.Session::get('name').' has Update A Posting Point.');
        Log::info('====================================');
        return redirect(route('point_post.index'))->with('status', 'Updating A Posting Point has been Success');
    }
    
    public function destroy($id)
    {
        $posting = $this->posting->findOrFail($id);
        $posting->fill([
            
        ])->save();
        Log::info('================DELETE Posting Point===================');
        Log::info('User '.Session::get('name').' has Delete/Void A Posting Point.');
        Log::info('====================================');
        return redirect(route('point_post.index'))->with('status', 'Deleting/Void A Posting Point  has been Success');
    }
}

<?php

namespace Vanguard\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Vanguard\GatePass;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Requests\GatePassRequest;
use Vanguard\Http\Resources\GatePassResource;
use Vanguard\Member;
use Vanguard\Payment;

class GatePassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        return $normalTimeLimit = ini_get('memory_limit');
        ini_set('memory_limit', '2048M');
        if ($request->start_date || $request->bmn_no) {
            $from = date("Y-m-d H:i:s",strtotime($request->start_date));
            $to = date("Y-m-d",strtotime($request->end_date))." 23:59:59";
            $gate_pass = new GatePass();
            $gate_pass_old = $gate_pass->setConnection('mysql_archived')->where('is_submit',1)->whereBetween('created_at', [$from, $to]);
            if($request->bmn_no !== 'null') $gate_pass_old = $gate_pass_old->where('bmn',$request->bmn_no);
            $gate_pass_old = $gate_pass_old->orderBy('id', 'desc')->get();
            $gate_pass_old->map(function ($data) {
                $data->payments = null;
                $data->member = null;
//                $data->payment = (object)[];
//                    $data->payment->id = 1;
//                    unset($data->payment);
                return $data;
            });
            $gate_pass_current = GatePass::with('payments')
                ->with(['member' => function ($query) {
                    $query->select('id', 'username','organization_name','gatepass_balance');

                }])->where('is_submit',1);
            $gate_pass_current = $gate_pass_current->whereBetween('created_at', [$from, $to]);
            if($request->bmn_no !== 'null')
                $gate_pass_current = $gate_pass_current->whereHas('member', function ($q) use ($request) {
                $q->where('username', $request->bmn_no);
                });
            $gate_pass_current = $gate_pass_current->orderBy('id', 'desc')->get();
            $merged = $gate_pass_current->concat($gate_pass_old);
            $all_gate_pass = $merged->all();
            return GatePassResource::collection($all_gate_pass);
        }elseif ($request->mawb_no) {
            $gate_pass = new GatePass();
            $gate_pass->setConnection('mysql_archived');
            $gate_pass_old = $gate_pass->where('is_submit',1)->where('master_airway_bill_no', 'like', '%' . $request->mawb_no . '%')->orderBy('id', 'desc')->get();
            $gate_pass_old->map(function ($data) {
                $data->payments = null;
                $data->member = null;
//                $data->payment = (object)[];
//                    $data->payment->id = 1;
//                    unset($data->payment);
                return $data;
            });
            $gate_pass_current = GatePass::with('payments')->where('is_submit',1)->where('master_airway_bill_no', 'like', '%' . $request->mawb_no . '%')->orderBy('id', 'desc')->get();
            $merged = $gate_pass_current->merge($gate_pass_old);
            $all_gate_pass = $merged->all();
            return GatePassResource::collection($all_gate_pass);
        } else {
            $date = date("Y-m-d H:i:s", strtotime("-3 day"));
            return GatePassResource::collection(GatePass::with('payments')->where('is_submit',1)->where('created_at', '>=', $date)->orderBy('id', 'desc')->get());
        }
    }

    public function saved_gatepass(Request $request)
    {
//        return $normalTimeLimit = ini_get('memory_limit');
        ini_set('memory_limit', '2048M');
        if ($request->start_date || $request->bmn_no) {
            $from = date("Y-m-d H:i:s",strtotime($request->start_date));
            $to = date("Y-m-d",strtotime($request->end_date))." 23:59:59";
            $gate_pass_current = GatePass::with('payments')
                ->with(['member' => function ($query) {
                    $query->select('id', 'username','organization_name','gatepass_balance');

                }])->where('is_submit',0);
            $gate_pass_current = $gate_pass_current->whereBetween('created_at', [$from, $to]);
            if($request->bmn_no !== 'null')
                $gate_pass_current = $gate_pass_current->whereHas('member', function ($q) use ($request) {
                $q->where('username', $request->bmn_no);
                });
            $gate_pass_current = $gate_pass_current->orderBy('id', 'desc')->get();
            $merged = $gate_pass_current;
            $all_gate_pass = $merged->all();
            return GatePassResource::collection($all_gate_pass);
        }elseif ($request->mawb_no) {
            $gate_pass_current = GatePass::with('payments')->where('is_submit',0)->where('master_airway_bill_no', 'like', '%' . $request->mawb_no . '%')->orderBy('id', 'desc')->get();
            $merged = $gate_pass_current;
            $all_gate_pass = $merged->all();
            return GatePassResource::collection($all_gate_pass);
        } else {
            $date = date("Y-m-d H:i:s", strtotime("-3 day"));
            return GatePassResource::collection(GatePass::with('payments')->where('is_submit',0)->where('created_at', '>=', $date)->orderBy('id', 'desc')->get());
        }
    }

    public function member_gate_pass(Request $request,Member $member)
    {
//        return $member;
//        return $normalTimeLimit = ini_get('memory_limit');
        ini_set('memory_limit', '2048M');
        if ($request->start_date) {
            $from = date("Y-m-d H:i:s",strtotime($request->start_date));
            $to = date("Y-m-d",strtotime($request->end_date))." 23:59:59";
            $gate_pass = new GatePass();
            $gate_pass_old = $gate_pass->setConnection('mysql_archived')->where('member_id', $member->id)->where('bmn',$member->username)->whereBetween('date', [$from, $to]);
            $gate_pass_old = $gate_pass_old->orderBy('id', 'desc')->limit(500)->get();
            $gate_pass_old->map(function ($data) {
                $data->payments = null;
                $data->member = null;
                return $data;
            });
            $gate_pass_current = GatePass::with('payments')
                ->with(['member' => function ($query) {
                    $query->select('id', 'username','organization_name','gatepass_balance');

                }])->where('member_id', $member->id);
            $gate_pass_current = $gate_pass_current->whereBetween('created_at', [$from, $to]);
//            if($request->bmn_no !== 'null')
//                $gate_pass_current = $gate_pass_current->whereHas('member', function ($q) use ($request) {
//                $q->where('username', $request->bmn_no);
//                });
            $gate_pass_current = $gate_pass_current->orderBy('id', 'desc')->limit(500)->get();
            $merged = $gate_pass_current->concat($gate_pass_old);
            $all_gate_pass = $merged->all();
            return GatePassResource::collection($all_gate_pass);
        }elseif ($request->mawb_no) {
            $gate_pass = new GatePass();
            $gate_pass_old = $gate_pass
                ->setConnection('mysql_archived')
                ->where('member_id', $member->id)
                ->where('bmn',$member->username)
                ->where('master_airway_bill_no', 'like', '%' . $request->mawb_no . '%')
                ->orderBy('id', 'desc')
                ->limit(500)
                ->get();
            $gate_pass_old->map(function ($data) {
                $data->payments = null;
                $data->member = null;
                return $data;
            });
            $gate_pass_current = GatePass::with('payments')->where('member_id', $member->id)->where('master_airway_bill_no', 'like', '%' . $request->mawb_no . '%')->orderBy('id', 'desc')->limit(500)->get();
            $merged = $gate_pass_current->merge($gate_pass_old);
            $all_gate_pass = $merged->all();
            return GatePassResource::collection($all_gate_pass);
        } else {
            return GatePassResource::collection(GatePass::with('payments')->where('member_id', $member->id)->orderBy('id', 'desc')->get());
        }
    }

    public function money_collection(){
        return GatePass::has('payments')->with('payments')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(GatePassRequest $request)
    {
        $allRequest = $request->all();
//        $objetoRequest = new Request();
//        $objetoRequest->setMethod('POST');
//        $objetoRequest->request->add(['mawb'=>$allRequest['master_airway_bill_no']]);
//        $find_gate_pass = $this->check_mawb($objetoRequest);
//        if($find_gate_pass > 0){
//            $gate_pass = GatePass::where('master_airway_bill_no',$request->master_airway_bill_no)->get();
//        }else{
//        return auth()->id();
//        $allRequest['dimension'] = empty($request->dimension) ? null : json_encode($request->dimension);
        $allRequest['receipt_no'] = $this->getLastGatePassID();
        $member = Member::findOrFail($request->member_id);
        $allRequest['member_id'] = $member->id;

                $gate_pass = GatePass::create($allRequest);
//        $member->updateBalance($request->amount);
                $gate_pass->member->updateBalance(-($request->amount));
//        $member->gate_pass()->create($allRequest);
//            }
        return response()->json($gate_pass);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gate_pass = GatePass::with(['payments', 'member', 'member_detail','on_behalf_of_member'])->findOrFail($id);
        return response()->json($gate_pass);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GatePass $gate_pass)
    {
        if ($request->print_times) {
            $request->validate([
                'print_times' => 'required|int'
            ]);
            $print_times = (int)$gate_pass->print_times;
            if ($print_times <= 3) {
                $gate_pass->update([
                    'print_times' => ++$print_times
                ]);
            }
            return response()->json($gate_pass->print_times);
        } elseif ($request->is_active) {
            $request->validate([
                'is_active' => 'required'
            ]);
            $gate_pass->update([
                'is_active' => true
            ]);
            return response()->json($gate_pass->is_active);
        } elseif ($request->created_user_id) {
            if($request->amount == 100){
                if($gate_pass->payments->count() > 0){
                    return 0;
                }
            }
            $payment = new Payment();
            $payment->created_user_id = $request->created_user_id;
            $payment->member_id = $gate_pass->member->id;
            $payment->bmn = $gate_pass->member->username;
            $payment->amount = $request->amount;
            $payment->receipt_no = 100.00;
            $payment->receipt_no = $this->getLastID();
            $gate_pass->payments()->save($payment);
            $gate_pass->member->updateBalance(-($request->amount));
            $gate_pass->SetUpdatedUserID($request->created_user_id);
            return response()->json($gate_pass->member->gatepass_balance);
        }
    }
    public function update_all(Request $request, GatePass $gate_pass)
    {
//            return $gate_pass;
            $allRequest = $request->all();
//            $allRequest['dimension'] = empty($request->dimension) ? null : json_encode($request->dimension);
//            $member = GatePass::findOrFail($request->member_id);
//            $company_owner = MemberAddress::firstOrNew(['id' => $owner['id']]);
//            $company_owner->fill($owner);
//            $company_owner->member_id = $member->id;
            $gate_pass->fill($allRequest);
            $gate_pass->save();
            return response()->json($gate_pass);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(GatePass $gate_pass)
    {
        $gate_pass->delete();
        return response()->json('Gate Pass Deleted Successfully');
    }

    public function check_mawb(Request $request){
//        return $request;
        if($request->id){
            return $get_last_id = GatePass::where('master_airway_bill_no', $request->mawb)
            ->where('id','<>',$request->id)
            ->count();
        }else{
            return $get_last_id = GatePass::where('master_airway_bill_no', $request->mawb)->count();
        }
    }

    protected function getLastID()
    {
        $today = date('Ymd', time());
        $get_last_id = Payment::where('receipt_no', 'like', $today . '%')->orderBy('id', 'desc')->first();
        if ($get_last_id) {
            $last_id = $get_last_id->receipt_no;
            $last_id++;
        } else {
            $last_id = $today . '001';
        }
        return $last_id;
    }

    protected function getLastGatePassID()
    {
        $today = date('ymd', time());
        $get_last_id = GatePass::where('receipt_no', 'like', $today . '%')->orderBy('id', 'desc')->first();
        if ($get_last_id) {
            $last_id = $get_last_id->receipt_no;
            $last_id++;
        } else {
            $last_id = $today . '00001';
        }
        return $last_id;
    }
}

<?php

namespace Vanguard\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Vanguard\Http\Resources\MoneyCollectionResource;
use Vanguard\IdCardReissue;
use Vanguard\Member;
use Vanguard\MemberDetail;
use Vanguard\MoneyCollection;
use Vanguard\Http\Controllers\Controller;
use Vanguard\RenewMember;
use Vanguard\Training;
use Vanguard\Verification;


class MoneyCollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /*if ($request->bmn_no) {
            $old_money_collections = new MoneyCollection();
            $old_money_collections->setConnection('mysql_archmember_id=' + this.member.idived');
            $old_collections = $old_money_collections->where('member_no', (int)$request->bmn_no)->orderBy('id', 'desc')->limit(500)->get();
            $old_collections->map(function ($data) {
                $data->money_receipt_name = 'Gate Pass / Amend';
                $data->member = null;
                return $data;
            });
            $current_money_collections = MoneyCollection::with('member')
                ->with(['member' => function ($query) {
                    $query->select('id', 'username', 'organization_name');

                }])
                ->whereHas('member', function ($q) use ($request) {
                    $q->where('username', $request->bmn_no);

                })
                ->orderBy('id', 'desc')->limit(500)->get();
            $merged = $current_money_collections->merge($old_collections);
            $money_collections = $merged->all();

        } elseif ($request->user_id) {
            $money_collections = MoneyCollection::with('member')
                ->with(['member' => function ($query) {
                    $query->select('id', 'username', 'organization_name');
                }])
                ->where('created_user_id', $request->user_id)
                ->orderBy('id', 'desc')->limit(500)->get();
        }*/
        ini_set('memory_limit', '2048M');
        if ($request->member_id) {
            $current_money_collections = MoneyCollection::with('member')->where('member_id', $request->member_id);

            if ($request->receipt_number && $request->receipt_number !== 'null')
                $current_money_collections = $current_money_collections->where('voucher_no', 'like', '%' . $request->receipt_number . '%');
            if ($request->receipt_type && $request->receipt_type !== 'null')
                $current_money_collections = $current_money_collections->where('receipt_type', $request->receipt_type);

            $money_collections = $current_money_collections->orderBy('id', 'desc')->get();
        } else if ($request->start_date) {

            $from = date($request->start_date);
            $to = date($request->end_date);

            $old_money_collections = new MoneyCollection();
            $old_money_collections->setConnection('mysql_archived');
            $old_collections = $old_money_collections->whereBetween('transaction_date', [$from, $to]);
            if ($request->bmn_no !== 'null') $old_collections = $old_collections->where('member_no', (int)$request->bmn_no);
            if ($request->user_name !== 'null') $old_collections = $old_collections->where('created_user_name', $request->user_name);
            $old_collections = $old_collections->orderBy('id', 'desc')->get();
            $old_collections->map(function ($data) {
                $data->receipt_type = 'gate_pass';
                $data->receipt_description = 'No';
                $data->money_receipt_name = 'Gate Pass / Amend';
                $data->member = null;
                return $data;
            });

            $current_money_collections = MoneyCollection::with('member')
                ->with(['member' => function ($query) {
                    $query->select('id', 'username', 'organization_name');

                }]);
            if ($request->bmn_no !== 'null')
                $current_money_collections = $current_money_collections->whereHas('member', function ($q) use ($request) {
                    $q->where('username', $request->bmn_no);
                });
            if ($request->user_id !== 'null') $current_money_collections = $current_money_collections->where('created_user_id', $request->user_id);
            $current_money_collections = $current_money_collections->whereBetween('transaction_date', [$from, $to]);
            $current_money_collections = $current_money_collections->orderBy('id', 'desc')->get();
            $merged = $current_money_collections->concat($old_collections);
            $money_collections = $merged->all();
        } else {
            $date = date("Y-m-d H:i:s", strtotime("-3 day"));
            $money_collections = MoneyCollection::with('member')->where('created_at', '>=', $date)->orderBy('id', 'desc')->get();
        }
        return MoneyCollectionResource::collection($money_collections);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//      $member = Member::where('username',$request->bmn_no)->first();
        $member = Member::findOrFail($request->member_id);
        $collection = new MoneyCollection();
//      $collection->member_id = $member->id;
        if (isset($request->payment_type)) $collection->payment_type = $request->payment_type;
        if (isset($request->payment_chq_no)) $collection->payment_chq_no = $request->payment_chq_no;
        if (isset($request->payment_chq_date))
            $collection->payment_chq_date = $request->payment_chq_date;
        else
            $collection->payment_chq_date = now();
        if (isset($request->payment_bank)) $collection->payment_bank = $request->payment_bank;
        $collection->voucher_no = $this->getLastID();
        $collection->receipt_type = $request->receipt_type;
        $collection->receipt_year = $request->receipt_year;
        $collection->receipt_month = $request->receipt_month;
        $collection->receipt_description = $request->description;
//      $collection->status = 'Active'
        $collection->amount = (int)$request->amount;
        $collection->transaction_date = now();
        $collection->created_user_id = $request->created_user_id;
        $collection->updated_user_id = 1;
        $collection->member_id = $request->member_id;
        $collection->save();
//        return $collection->id;
//        $member->money_collections()->save($collection);
        if ($collection->receipt_type == 'gate_pass') {
            $member->updateBalance($request->amount);
        } elseif ($collection->receipt_type == 'id_card') {
            $verification = Verification::findOrFail($request->verification_id);
            $verification->savePaymentHistory($collection->id);
        } elseif ($collection->receipt_type == 'reissue_id_card') {
            $idcard_reissue = IdCardReissue::findOrFail($request->receipt_id);
            $idcard_reissue->savePaymentHistory($collection->id);
        } elseif ($collection->receipt_type == 'new_membership') {
            $member_detail = MemberDetail::findOrFail($request->receipt_id);
            $member_detail->savePaymentHistory($collection->id);
        }elseif ($collection->receipt_type == 'membership_annual_subscription') {
            $member_detail = RenewMember::findOrFail($request->receipt_id);
            $member_detail->savePaymentHistory($collection->id);
            $member->member_detail->updateLastRenewYear($collection->receipt_year);
        }elseif ($collection->receipt_type == 'membership_structure_change') {
            $member_detail = RenewMember::findOrFail($request->receipt_id);
            $member_detail->savePaymentHistory($collection->id);
        }elseif (Str::contains($collection->receipt_type, '_training')) {
            $member_detail = Training::findOrFail($request->receipt_id);
            $member_detail->savePaymentHistory($collection->id);
        }
        return response()->json($collection);
    }

    protected function getLastID()
    {
        $today = date('Ymd', time());
        $get_last_id = MoneyCollection::where('voucher_no', 'like', '%' . $today . '%')->orderBy('id', 'desc')->first();
        if ($get_last_id) {
            $last_id = $get_last_id->voucher_no;
            $last_id++;
        } else {
            $last_id = 'RV--' . $today . '001';
        }
        return $last_id;
    }

    /**
     * Display the specified resource.
     *
     * @param \Vanguard\MoneyCollection $moneyCollection
     * @return \Illuminate\Http\Response
     */
    public function show(MoneyCollection $moneyCollection)
    {
        return new MoneyCollectionResource($moneyCollection);
//        return $moneyCollection->member;
//        $gate_pass = GatePass::with(['payment', 'member', 'member_detail'])->findOrFail($id);
//        return response()->json($moneyCollection);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Vanguard\MoneyCollection $moneyCollection
     * @return \Illuminate\Http\Response
     */
    public function edit(MoneyCollection $moneyCollection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Vanguard\MoneyCollection $moneyCollection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MoneyCollection $moneyCollection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Vanguard\MoneyCollection $moneyCollection
     * @return \Illuminate\Http\Response
     */
    public function destroy(MoneyCollection $moneyCollection)
    {
        //
    }
}

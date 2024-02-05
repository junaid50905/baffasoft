<?php

namespace Vanguard\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Requests\IdCardRequest as IdCardRequests;
use Vanguard\Http\Resources\IdCardCancelResource;
use Vanguard\Http\Resources\IdCardReissueResource;
use Vanguard\Http\Resources\VerificationResource;
use Vanguard\IdCardCancel;
use Vanguard\IdCardFormYear;
use Vanguard\IdCardReissue;
use Vanguard\IdCardRequest as IdCardRequest;
use Vanguard\Http\Resources\IdCardResource;
use Vanguard\IdCard;
use Vanguard\Member;
use Vanguard\Verification;

class IdCardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public const status = ['pending','']
    public function index(Request $request)
    {
        if ($request->search_panel) {
            if ($request->search_panel == 'report_panel') {

                $from = date($request->start_date);
                $to = date($request->end_date);


                $id_cards = IdCard::with(array('members' => function ($query) {
                    $query->select(['username', 'organization_name']);
                }))
                    ->join('id_card_member', 'id_card_member.id_card_id', '=', 'id_cards.id')
                    ->join('members', 'members.id', '=', 'id_card_member.member_id');
                if ($request->bmn_no !== 'null') $id_cards = $id_cards->where('members.username', $request->bmn_no);
                if ($request->status) if ($request->status !== 'null') $id_cards = $id_cards->where('id_cards.status', $request->status);
                $id_cards = $id_cards->whereBetween('id_cards.created_at', [$from . " 00:00:00", $to . " 23:59:59"]);
                $id_cards = $id_cards->select('id_cards.id as id', 'id_cards.member_id AS member_id', 'id_cards.id_card_number AS id_card_number', 'id_cards.*', 'id_cards.status AS status_code');
                $id_cards = $id_cards->orderBy('id', 'desc')->distinct()->get();

                /*

                $id_cards = IdCard::with(array('members' => function ($query) {
                    $query->select(['username', 'organization_name']);

                }));

                if ($request->bmn_no !== 'null')
                    $id_cards = $id_cards->whereHas('members', function ($q) use ($request) {
                        $q->where('username', $request->bmn_no);
                    });

                if ($request->status !== 'null') $id_cards = $id_cards->where('status', $request->status);
                if ($request->submission_year) {
                    if ($request->submission_year !== 'null') $id_cards = $id_cards->where('form_year', $request->submission_year);
                }

                $id_cards = $id_cards->whereBetween('created_at', [$from . " 00:00:00", $to . " 23:59:59"]);
                $id_cards = $id_cards->orderBy('id', 'desc')->get();*/
                $all_id_cards = $id_cards;
            } else if ($request->search_panel == 'id_card_department') {


//                if (!Cache::has('id_card_department_report')) {
//                    Cache::remember('id_card_department_report', 10, function () use ($request) {
                        $id_cards = IdCard::with(array('members' => function ($query) {
                            $query->select(['username', 'organization_name']);
                        }))
                            ->join('id_card_member', 'id_card_member.id_card_id', '=', 'id_cards.id')
                            ->join('members', 'members.id', '=', 'id_card_member.member_id');
                        if ($request->bmn_no !== 'null') $id_cards = $id_cards->where('members.username', $request->bmn_no);
                        if ($request->status !== 'null') $id_cards = $id_cards->where('id_cards.status', $request->status);
                        if ($request->search_card_holder_name !== 'null') $id_cards = $id_cards->whereLike('card_holder_name', $request->search_card_holder_name);
                        if ($request->search_id_card_number !== 'null') $id_cards = $id_cards->whereLike('id_card_number', $request->search_id_card_number);
                        if ($request->submission_year !== 'null') $id_cards = $id_cards->where('form_year', $request->submission_year);
                        $id_cards = $id_cards->select('id_cards.id as id', 'id_cards.member_id AS member_id', 'id_cards.id_card_number AS id_card_number', 'id_cards.*', 'id_cards.status AS status_code');
                        $id_cards = $id_cards->orderBy('id', 'desc')->distinct()->get();
//                        return $id_cards;
//                    });
//                }

//                $id_cards = Cache::get('id_card_department_report');

                /*
                                $id_cards = IdCard::with(array('members' => function ($query) {
                                    $query->select(['username', 'organization_name']);

                                }));

                                if ($request->bmn_no !== 'null')
                                    $id_cards = $id_cards->whereHas('members', function ($q) use ($request) {
                                        $q->where('username', $request->bmn_no);
                                    });
                                if ($request->status !== 'null') $id_cards = $id_cards->where('status', $request->status);
                                if ($request->search_card_holder_name !== 'null') $id_cards = $id_cards->whereLike('card_holder_name', $request->search_card_holder_name);
                                if ($request->search_id_card_number !== 'null') $id_cards = $id_cards->whereLike('id_card_number', $request->search_id_card_number);
                                if ($request->submission_year !== 'null') $id_cards = $id_cards->where('form_year', $request->submission_year);

                //                $id_cards = $id_cards->whereBetween('created_at', [$from . " 00:00:00", $to . " 23:59:59"]);
                                $id_cards = $id_cards->orderBy('id', 'desc')->get();
                */
                $all_id_cards = $id_cards;
            }
        } else {
            $date = date("Y-m-d H:i:s", strtotime("-3 day"));
            $all_id_cards = IdCard::where('created_at', '>=', $date)->orderBy('id', 'desc')->get();
//        return IdCard::all();

        }
//        return $all_id_cards;
        return IdCardResource::collection($all_id_cards);

    }

    public function id_card_year()
    {
        return IdCardFormYear::all();
    }

    public function save_id_card_year(Request $request)
    {
        if (is_numeric($request->id)) {
            $companyOwner = IdCardFormYear::findOrFail($request->id);
        } else {
            $companyOwner = new IdCardFormYear();
        }
        $companyOwner->fill($request->all())->save();
        return response()->json($companyOwner);
    }

    public function all_id_card_status()
    {
        $status = \IdCardStatus::$positions;
        $all_status = [];
        foreach ($status as $k => $v) {
            $all_status[$k]['id'] = $k;
            $all_status[$k]['name'] = $v;
        }
        return $all_status;
    }

    public function generate_id_card_number(IdCard $idCard)
    {
        $form_year = $idCard->form_year;
        $id_card_number = '990001';
        if ($form_year) {
            $get_last_id = IdCard::where('form_year', $idCard->form_year)->orderBy('id_card_number', 'desc')->first();
            if ($get_last_id && is_numeric($get_last_id->id_card_number)) {
                $id_card_number = intval($get_last_id->id_card_number);
                $id_card_number++;
            } else {
                $id_card_number = substr($idCard->form_year, 2, 2) . '0001';
            }
        }
        return $id_card_number;
    }

    public function member_id_cards($id)
    {
//        return Member::find($id)->id_cards;
//        return DB::table('members')->get();
        $verifications = Member::find($id)->verifications;
        $all_id_cards = Member::find($id)->member_id_cards()->pluck("id_cards.id")->toArray();
        $verified_id_cards = [];
        foreach ($verifications as $verification) {
            foreach ($verification->id_cards as $id_card) {
                $verified_id_cards[] = $id_card->id;
            }
        }
//        return $verified_id_cards;
        $difference = array_diff($all_id_cards, $verified_id_cards);

        $result['noVerified'] = IdCardResource::collection(IdCard::whereIn('id', $difference)->get());
        $result['verified'] = VerificationResource::collection(Member::find($id)->verifications);
        return $result;
//        return Member::find($id)->verifications;
//        return Verification::where
//        return IdCardResource::collection(IdCard::where('member_id', $id)->orderBy('id', 'desc')->get());
//        return IdCard::all();
    }

    public function accounts_id_cards(Request $request)
    {
        if ($request->bmn_no && $request->bmn_no != 'null') {

//        return Verification::find('2')->id_cards->where('status', 5);
//        return IdCardResource::collection(IdCard::where('status','>',4)->orderBy('id', 'desc')->get());
//        return IdCard::all();
            DB::statement(DB::raw('set @rownum:=0'));
            $verifications = DB::table('verifications')
                ->join('members', 'members.id', '=', 'verifications.member_id')
//            ->join('id_card_member', 'members.id', '=', 'id_card_member.member_id')
                ->join('id_card_verification', 'verifications.id', '=', 'id_card_verification.verification_id')
                ->join('id_cards AS idCrd', 'id_card_verification.id_card_id', '=', 'idCrd.id')
//            ->join('id_cards', 'id_card_member.id_card_id', '=', 'id_cards.id')
                ->select('verifications.id', 'verifications.money_collection_id',
                    DB::raw('@rownum:=@rownum+1 as row_num'),
                    DB::raw("'ID Card' as purpose"),
                    'verifications.approved_date', 'verifications.form_year',
                    'verifications.is_payment',
                    'members.id AS member_id',
                    'members.organization_name',
                    DB::raw('GROUP_CONCAT(bafidCrd.memship_no) AS membership_no'),
                    DB::raw('(GROUP_CONCAT(bafidCrd.id)) AS id_cards'),
                    DB::raw('(GROUP_CONCAT(bafidCrd.status)) AS id_card_status'),
                    //DB::raw('(SELECT count(*) FROM bafid_cards AS bafidCrd2 WHERE bafidCrd2.id IN (CAST(GROUP_CONCAT(bafidCrd.id) AS CHAR)) ) AS id_card_price'),
//                    DB::raw('(SELECT count(bafgate_passes.id) FROM bafgate_passes where bafgate_passes.member_id = bafmembers.id AND created_at >= DATE_SUB(NOW(),INTERVAL 1 YEAR)) AS gate_pass_count'),
//                    DB::raw('IFNULL((SELECT total FROM bafid_card_records AS previous_id_card_record where previous_id_card_record.member_id = bafmembers.id AND year = 2021),0) AS previous_year_id_card'),
//                    DB::raw('IFNULL((SELECT total FROM bafid_card_records AS current_id_card_record where current_id_card_record.member_id = bafmembers.id AND year = 2022),0) AS current_year_id_card'),
                    DB::raw('count(bafidCrd.id) as desired_id_card'), 'verifications.verification_required', 'verifications.verification_accept', 'verifications.manager_note', 'verifications.member_message'
                )
//            ->where('idCrd.status','3')
                ->where('verifications.verification_accept', '<>', '0')
                ->where('members.username', $request->bmn_no)
                ->where('verifications.is_approved', 1)
                ->orderByDesc('verifications.id')
                ->groupBy('verifications.id')
                ->get();
            $new_verifications = [];
            foreach ($verifications as $k => $verification) {
                $new_verifications[$k] = $verification;
                $memship_no = DB::table('id_cards')->select('memship_no')->whereIn('id', explode(',', $verification->id_cards))->where('status', '>=', 6)->pluck('memship_no')->toArray();
                if ($memship_no)
                    $new_verifications[$k]->verification_accept_count = count(explode(',', implode(',', $memship_no)));
                else
                    $new_verifications[$k]->verification_accept_count = 0;
            }
            return $new_verifications;
        } else {

//        return Verification::find('2')->id_cards->where('status', 5);
//        return IdCardResource::collection(IdCard::where('status','>',4)->orderBy('id', 'desc')->get());
//        return IdCard::all();
            DB::statement(DB::raw('set @rownum:=0'));
            $verifications = DB::table('verifications')
                ->join('members', 'members.id', '=', 'verifications.member_id')
//            ->join('id_card_member', 'members.id', '=', 'id_card_member.member_id')
                ->join('id_card_verification', 'verifications.id', '=', 'id_card_verification.verification_id')
                ->join('id_cards AS idCrd', 'id_card_verification.id_card_id', '=', 'idCrd.id')
//            ->join('id_cards', 'id_card_member.id_card_id', '=', 'id_cards.id')
                ->select('verifications.id', 'verifications.money_collection_id',
                    DB::raw('@rownum:=@rownum+1 as row_num'),
                    DB::raw("'ID Card' as purpose"),
                    'verifications.approved_date', 'verifications.form_year',
                    'verifications.is_payment',
                    'members.id AS member_id',
                    'members.organization_name',
                    DB::raw('GROUP_CONCAT(bafidCrd.memship_no) AS membership_no'),
                    DB::raw('(GROUP_CONCAT(bafidCrd.id)) AS id_cards'),
                    DB::raw('(GROUP_CONCAT(bafidCrd.status)) AS id_card_status'),
                    //DB::raw('(SELECT count(*) FROM bafid_cards AS bafidCrd2 WHERE bafidCrd2.id IN (CAST(GROUP_CONCAT(bafidCrd.id) AS CHAR)) ) AS id_card_price'),
//                    DB::raw('(SELECT count(bafgate_passes.id) FROM bafgate_passes where bafgate_passes.member_id = bafmembers.id AND created_at >= DATE_SUB(NOW(),INTERVAL 1 YEAR)) AS gate_pass_count'),
//                    DB::raw('IFNULL((SELECT total FROM bafid_card_records AS previous_id_card_record where previous_id_card_record.member_id = bafmembers.id AND year = 2021),0) AS previous_year_id_card'),
//                    DB::raw('IFNULL((SELECT total FROM bafid_card_records AS current_id_card_record where current_id_card_record.member_id = bafmembers.id AND year = 2022),0) AS current_year_id_card'),
                    DB::raw('count(bafidCrd.id) as desired_id_card'), 'verifications.verification_required', 'verifications.verification_accept', 'verifications.manager_note', 'verifications.member_message'
                )
//            ->where('idCrd.status','3')
                ->where('verifications.verification_accept', '<>', '0')
                ->where('verifications.is_approved', 1)
                ->orderByDesc('verifications.id')
                ->groupBy('verifications.id')
                ->get();
            $new_verifications = [];
            foreach ($verifications as $k => $verification) {
                $new_verifications[$k] = $verification;
                $memship_no = DB::table('id_cards')->select('memship_no')->whereIn('id', explode(',', $verification->id_cards))->where('status', '>=', 6)->pluck('memship_no')->toArray();
                if ($memship_no)
                    $new_verifications[$k]->verification_accept_count = count(explode(',', implode(',', $memship_no)));
                else
                    $new_verifications[$k]->verification_accept_count = 0;
            }
            return $new_verifications;
        }
    }

    public function member_id_card_receipts(Member $member)
    {
//        return $member;
        DB::statement(DB::raw('set @rownum:=0'));
        return DB::table('verifications')
            ->join('members', 'members.id', '=', 'verifications.member_id')
            ->join('id_card_verification', 'verifications.id', '=', 'id_card_verification.verification_id')
            ->join('id_cards', 'id_card_verification.id_card_id', '=', 'id_cards.id')
            ->select('verifications.id', 'verifications.money_collection_id',
                DB::raw('@rownum:=@rownum+1 as row_num'),
                DB::raw("'ID Card' as purpose"),
                'verifications.approved_date',
                'verifications.is_payment',
                'members.id AS member_id',
                'members.organization_name',
                DB::raw('(SELECT count(bafgate_passes.id) FROM bafgate_passes where bafgate_passes.member_id = bafmembers.id AND created_at >= DATE_SUB(NOW(),INTERVAL 1 YEAR)) AS gate_pass_count'),
                DB::raw('IFNULL((SELECT total FROM bafid_card_records AS previous_id_card_record where previous_id_card_record.member_id = bafmembers.id AND year = 2021),0) AS previous_year_id_card'),
                DB::raw('IFNULL((SELECT total FROM bafid_card_records AS current_id_card_record where current_id_card_record.member_id = bafmembers.id AND year = 2022),0) AS current_year_id_card'),
                DB::raw('count(bafid_cards.id) as desired_id_card'), 'verifications.verification_required', 'verifications.verification_accept', 'verifications.manager_note', 'verifications.member_message'
            )
//            ->where('id_cards.status','2')
            ->where('verifications.member_id', $member->id)
            ->where('verifications.is_approved', 1)
            ->groupBy('verifications.id')
            ->get();
    }

    public function manager_report(Request $request)
    {
        if ($request->bmn_no && $request->bmn_no != 'null') {
            DB::statement(DB::raw('set @rownum:=0'));
            return DB::table('verifications')
                ->join('members', 'members.id', '=', 'verifications.member_id')
//            ->join('id_card_member', 'members.id', '=', 'id_card_member.member_id')
                ->join('id_card_verification', 'verifications.id', '=', 'id_card_verification.verification_id')
                ->join('id_cards', 'id_card_verification.id_card_id', '=', 'id_cards.id')
//            ->join('id_cards', 'id_card_member.id_card_id', '=', 'id_cards.id')
                ->select('verifications.id',
                    DB::raw('@rownum:=@rownum+1 as row_num'),
                    'verifications.verification_date', 'verifications.form_year',
                    'members.organization_name',
                    DB::raw('(SELECT count(bafgate_passes.id) FROM bafgate_passes where bafgate_passes.member_id = bafmembers.id AND created_at >= DATE_SUB(NOW(),INTERVAL 1 YEAR)) AS gate_pass_count'),
//                    DB::raw('IFNULL((SELECT total FROM bafid_card_records AS previous_id_card_record where previous_id_card_record.member_id = bafmembers.id AND year = 2021),0) AS previous_year_id_card'),
//                    DB::raw('IFNULL((SELECT total FROM bafid_card_records AS current_id_card_record where current_id_card_record.member_id = bafmembers.id AND year = 2022),0) AS current_year_id_card'),
                    DB::raw('IFNULL((SELECT count(previous_id_card_record.id) FROM bafid_cards AS previous_id_card_record where previous_id_card_record.member_id = bafmembers.id AND previous_id_card_record.form_year = bafverifications.form_year - 1 AND previous_id_card_record.status = 10),0) AS previous_year_id_card'),
                    DB::raw('IFNULL((SELECT count(current_id_card_record.id) FROM bafid_cards AS current_id_card_record where current_id_card_record.member_id = bafmembers.id AND current_id_card_record.form_year = bafverifications.form_year AND current_id_card_record.status = 10),0) AS current_year_id_card'),
                    DB::raw('count(bafid_cards.id) as desired_id_card'), 'verifications.verification_required', 'verifications.verification_accept', 'verifications.manager_note', 'verifications.member_message'
                )
//            ->where('id_cards.status','2')
                ->where('members.username', $request->bmn_no)
                ->where('verifications.is_approved', 0)
                ->groupBy('verifications.id')
                ->get();
        } else {

            DB::statement(DB::raw('set @rownum:=0'));
            return DB::table('verifications')
                ->join('members', 'members.id', '=', 'verifications.member_id')
//            ->join('id_card_member', 'members.id', '=', 'id_card_member.member_id')
                ->join('id_card_verification', 'verifications.id', '=', 'id_card_verification.verification_id')
                ->join('id_cards', 'id_card_verification.id_card_id', '=', 'id_cards.id')
//            ->join('id_cards', 'id_card_member.id_card_id', '=', 'id_cards.id')
                ->select('verifications.id',
                    DB::raw('@rownum:=@rownum+1 as row_num'),
                    'verifications.verification_date', 'verifications.form_year',
                    'members.organization_name',
                    DB::raw('(SELECT count(bafgate_passes.id) FROM bafgate_passes where bafgate_passes.member_id = bafmembers.id AND created_at >= DATE_SUB(NOW(),INTERVAL 1 YEAR)) AS gate_pass_count'),
//                    DB::raw('IFNULL((SELECT total FROM bafid_card_records AS previous_id_card_record where previous_id_card_record.member_id = bafmembers.id AND year = 2021),0) AS previous_year_id_card'),
//                    DB::raw('IFNULL((SELECT total FROM bafid_card_records AS current_id_card_record where current_id_card_record.member_id = bafmembers.id AND year = 2022),0) AS current_year_id_card'),
                    DB::raw('IFNULL((SELECT count(previous_id_card_record.id) FROM bafid_cards AS previous_id_card_record where previous_id_card_record.member_id = bafmembers.id AND previous_id_card_record.form_year = bafverifications.form_year - 1 AND previous_id_card_record.status = 10),0) AS previous_year_id_card'),
                    DB::raw('IFNULL((SELECT count(current_id_card_record.id) FROM bafid_cards AS current_id_card_record where current_id_card_record.member_id = bafmembers.id AND current_id_card_record.form_year = bafverifications.form_year AND current_id_card_record.status = 10),0) AS current_year_id_card'),
                    DB::raw('count(bafid_cards.id) as desired_id_card'), 'verifications.verification_required', 'verifications.verification_accept', 'verifications.manager_note', 'verifications.member_message'
                )
//            ->where('id_cards.status','2')
                ->where('verifications.is_approved', 0)
                ->groupBy('verifications.id', 'verifications.form_year')
                ->get();


            /*
                     $subQuery = DB::table('gate_passes')
                         ->select(DB::raw('count(bafgate_passes.id)'))
                         ->join('gate_passes.member_id','bafmembers.id');
                     $sql_with_bindings = vsprintf(str_replace(['?'], ['\'%s\''], $subQuery->toSql()), $subQuery->getBindings());
                    return DB::table('members')
                        ->join('id_card_member', 'members.id', '=', 'id_card_member.member_id')
                        ->join('id_cards', 'id_card_member.id_card_id', '=', 'id_cards.id')
                        ->select('members.organization_name AS company_name', DB::raw('count(bafid_cards.id) as desired_id_card'), DB::raw('GROUP_CONCAT(bafid_cards.comment) as comments'),
                            DB::raw("({$sql_with_bindings}) as gate_pass_count")
                        )->groupBy('members.id')
                        ->toSql();*/


//            Member::whereNotNull('organization_name')->with('id_cards')->get();//->select('username','organization_name');

        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(IdCardRequests $request)
    {
//        $member = Member::findOrFail($request->member_id);
        $allRequest = $request->all();
        $id_card = IdCard::create($allRequest);
//        $member->id_card()->create($allRequest);
        $id_card->members()->attach(explode(",", $request->selected_organizations));
        $any_image = false;
        $target_dir = 'attached_images/id_cards/' . $id_card->id;
        $productImage = $request->file('attachment_file');
        if (is_file($productImage)) {
            $imageUrl = $this->productImageUpload($productImage, $target_dir);
            $id_card->attachment_file = $imageUrl;
            $any_image = true;
        }
        $productImage = $request->file('signatory_attachment');
        if (is_file($productImage)) {
            $imageUrl = $this->productImageUpload($productImage, $target_dir);
            $id_card->signatory_attachment = $imageUrl;
            $any_image = true;
        }
        $productImage = $request->file('card_holder_signature_attachment');
        if (is_file($productImage)) {
            $imageUrl = $this->productImageUpload($productImage, $target_dir);
            $id_card->card_holder_signature_attachment = $imageUrl;
            $any_image = true;
        }
        $productImage = $request->file('card_holder_photograph_attachment');
        if (is_file($productImage)) {
            $imageUrl = $this->productImageUpload($productImage, $target_dir);
            $id_card->card_holder_photograph_attachment = $imageUrl;
            $any_image = true;
        }
        $productImage = $request->file('police_verification_attachment');
        if (is_file($productImage)) {
            $imageUrl = $this->productImageUpload($productImage, $target_dir);
            $id_card->police_verification_attachment = $imageUrl;
            $any_image = true;
        }
        if ($any_image) {
            $id_card->save();
        }

        return response()->json($id_card);
    }

    public function save_cancel_id_card(Request $request)
    {
        $id_card = IdCard::findOrFail($request->id_card_id);
        $allRequest = $request->all();
        $id_card->id_card_cancel()->create($allRequest);
        return response()->json($id_card->id_card_cancel);
    }

    public function cancel_id_card(IdCardCancel $idCardCancel)
    {
        return new IdCardCancelResource($idCardCancel);
    }

    public function update_cancel_id_card(IdCardCancel $idCardCancel)
    {
        $idCardCancel->update(['status' => 'Canceled', 'submit_date' => date("Y-m-d")]);
        return response()->json('ID Card Cancel Application Approved Successfully');
    }

    public function cancel_index(Request $request)
    {
        $from = date($request->start_date);
        $to = date($request->end_date);

//        return IdCardCancel::find('1')->members;
        if ($request->search_panel) {
            $cancel_id_cards = IdCardCancel::with(array('member' => function ($query) {
                $query->select(['username', 'organization_name']);

            }));
            if ($request->bmn_no !== 'null')
                $cancel_id_cards = $cancel_id_cards->whereHas('id_card', function ($qq) use ($request) {
                    $qq->whereHas('members', function ($q) use ($request) {
                        $q->where('username', $request->bmn_no);
                    });
                });
            if ($request->search_card_holder_name !== 'null')
                $cancel_id_cards = $cancel_id_cards->whereHas('id_card', function ($q) use ($request) {
                    $q->whereLike('card_holder_name', $request->search_card_holder_name);
                });
            if ($request->search_id_card_number !== 'null')
                $cancel_id_cards = $cancel_id_cards->whereHas('id_card', function ($q) use ($request) {
                    $q->whereLike('id_card_number', $request->search_id_card_number);
                });
            if ($request->status !== 'null') $cancel_id_cards = $cancel_id_cards->where('status', $request->status);
            $cancel_id_cards = $cancel_id_cards->whereBetween('created_at', [$from . " 00:00:00", $to . " 23:59:59"]);
            $cancel_id_cards = $cancel_id_cards->orderBy('id', 'desc')->get();
            $all_id_cards = $cancel_id_cards;

        } else if ($request->member_id) {
            $member = Member::findOrFail($request->member_id);
            $all_id_cards = $member->id_card_cancels;
        } else {
            $date = date("Y-m-d H:i:s", strtotime("-3 day"));
            $all_id_cards = IdCardCancel::orderBy('id', 'desc')->get();
        }
        return IdCardCancelResource::collection($all_id_cards);
    }

    public function save_reissue_id_card(Request $request)
    {
        $request->validate([
            'attachment_file' => 'mimes:jpeg,png,jpg,pdf|max:2048'
        ]);
        $id_card = IdCard::findOrFail($request->id_card_id);
        $allRequest = $request->all();
        $id_card->id_card_reissue()->create($allRequest);
        $target_dir = 'attached_images/id_cards_reissue/' . $id_card->id;
        $productImage = $request->file('attachment_file');
        if (is_file($productImage)) {
            $imageUrl = $this->productImageUpload($productImage, $target_dir);
            $id_card->id_card_reissue->attachment_file = $imageUrl;
            $id_card->push();
        }
        return response()->json($id_card->id_card_cancel);
    }

    public function reissue_id_card(IdCardReissue $idCardReissue)
    {
        return new IdCardReissueResource($idCardReissue);
    }

    public function update_reissue_id_card(Request $request, IdCardReissue $idCardReissue)
    {
        if ($request->new_proximity_number) {
            $idCardReissue->id_card->proximity_number = $request->new_proximity_number;
            $idCardReissue->push();
            $idCardReissue->update(['status' => 'Ready']);
        } else {
            if ($request->status == 'Delivered')
                $idCardReissue->update(['status' => $request->status, 'submit_date' => date("Y-m-d")]);
            else
                $idCardReissue->update(['status' => $request->status]);
        }
        return response()->json('Reissue ID Card Updated Successfully');
    }

    public function reissue_index(Request $request)
    {
//        return IdCardCancel::find('1')->members;
        $from = date($request->start_date);
        $to = date($request->end_date);

        if ($request->search_panel) {
            $cancel_id_cards = IdCardReissue::with(array('member' => function ($query) {
                $query->select(['username', 'organization_name']);

            }));
            if ($request->bmn_no !== 'null')
                $cancel_id_cards = $cancel_id_cards->whereHas('id_card', function ($qq) use ($request) {
                    $qq->whereHas('members', function ($q) use ($request) {
                        $q->where('username', $request->bmn_no);
                    });
                });
            if ($request->search_card_holder_name !== 'null')
                $cancel_id_cards = $cancel_id_cards->whereHas('id_card', function ($q) use ($request) {
                    $q->whereLike('card_holder_name', $request->search_card_holder_name);
                });
            if ($request->search_id_card_number !== 'null')
                $cancel_id_cards = $cancel_id_cards->whereHas('id_card', function ($q) use ($request) {
                    $q->whereLike('id_card_number', $request->search_id_card_number);
                });
            if ($request->status !== 'null') $cancel_id_cards = $cancel_id_cards->where('status', $request->status);
            $cancel_id_cards = $cancel_id_cards->whereBetween('created_at', [$from . " 00:00:00", $to . " 23:59:59"]);
            $cancel_id_cards = $cancel_id_cards->orderBy('id', 'desc')->get();
            $all_id_cards = $cancel_id_cards;

        } else if ($request->member_id) {
            $member = Member::findOrFail($request->member_id);
            $all_id_cards = $member->id_card_reissues;
        } else {
            $date = date("Y-m-d H:i:s", strtotime("-3 day"));
            $all_id_cards = IdCardReissue::orderBy('id', 'desc')->get();
        }
        return IdCardReissueResource::collection($all_id_cards);
    }

    /**
     * Display the specified resource.
     *
     * @param \Vanguard\IdCard $idCard
     * @return \Illuminate\Http\Response
     */
    public function show(IdCard $idCard)
    {
//        return $idCard->members;
//        return $idCard->company_owner->name;
        $idCard = IdCard::with(['company_owner', 'member'])
            ->with(['members' => function ($query) {
                $query->select('organization_name');
            }])->findOrFail($idCard->id);
        return response()->json($idCard);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Vanguard\IdCard $idCard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IdCard $idCard)
    {
        //
    }

    public function update_all(Request $request, IdCard $id_card)
    {
//            return $gate_pass;
        $allRequest = $request->all();
//            $allRequest['dimension'] = empty($request->dimension) ? null : json_encode($request->dimension);
//            $member = GatePass::findOrFail($request->member_id);
//            $company_owner = MemberAddress::firstOrNew(['id' => $owner['id']]);
//            $company_owner->fill($owner);
//            $company_owner->member_id = $member->id;
        $id_card->fill($allRequest);
        $id_card->save();

        $any_image = false;
        $target_dir = 'attached_images/id_cards/' . $id_card->id;
        $productImage = $request->file('attachment_file');
        if (is_file($productImage)) {
            $imageUrl = $this->productImageUpload($productImage, $target_dir);
            $id_card->attachment_file = $imageUrl;
            $any_image = true;
        }
        $productImage = $request->file('signatory_attachment');
        if (is_file($productImage)) {
            $imageUrl = $this->productImageUpload($productImage, $target_dir);
            $id_card->signatory_attachment = $imageUrl;
            $any_image = true;
        }
        $productImage = $request->file('card_holder_signature_attachment');
        if (is_file($productImage)) {
            $imageUrl = $this->productImageUpload($productImage, $target_dir);
            $id_card->card_holder_signature_attachment = $imageUrl;
            $any_image = true;
        }
        $productImage = $request->file('card_holder_photograph_attachment');
        if (is_file($productImage)) {
            $imageUrl = $this->productImageUpload($productImage, $target_dir);
            $id_card->card_holder_photograph_attachment = $imageUrl;
            $any_image = true;
        }
        $productImage = $request->file('police_verification_attachment');
        if (is_file($productImage)) {
            $imageUrl = $this->productImageUpload($productImage, $target_dir);
            $id_card->police_verification_attachment = $imageUrl;
            $any_image = true;
        }
        if ($any_image) {
            $id_card->save();
        }

        return response()->json($id_card);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Vanguard\IdCard $idCard
     * @return \Illuminate\Http\Response
     */
    public function accepts_by_director(Request $request)
    {
        $validated = $request->validate([
            'verification' => 'required|json'
        ]);
        $verifications = json_decode($request->verification);
        foreach ($verifications as $verificationObj) {
            $verification = Verification::findOrFail($verificationObj->verification_id);//acception
            if ($verification) {
                $verification->update(['approved_date' => date("Y-m-d"), 'verification_required' => $verificationObj->verification_required, 'verification_accept' => $verificationObj->verification_accept, 'is_approved' => '1']); //Accepted
                $verification->member->member_notifications()->create([
                    'money_receipt_type_id' => 7,
                    'message_title' => 'ID Card Approval',
                    'message_description' => "Out of {$verificationObj->verification_required} Request, {$verificationObj->verification_accept} ID Card have been Approved"
                ]);
                if ($verificationObj->verification_required == $verificationObj->verification_accept)
                    $verification->id_cards()->update(['status' => '6']);//Accepted
                elseif ($verificationObj->verification_accept == 0)
                    $verification->id_cards()->update(['status' => '4']);//Cancelled
                else
                    $verification->id_cards()->update(['status' => '3']);//Selection
            }
        }
        return response()->json('Director Accepted');
    }

//    public function accept_by_director(Request $request, Verification $verification)
//    {
//        $verification->update(['verification_required'=>$request->verification_required,'verification_accept'=>$request->verification_accept,'is_approved'=>'1']); //Accepted
//        $verification->member->member_notifications()->create([
//            'money_receipt_type_id'=>7,
//            'message_title'=>'ID Card Approval',
//            'message_description' => "Out of {$request->verification_required} Request, {$request->verification_accept} ID Card have been Approved"
//        ]);
//        $verification->id_cards()->update(['status'=>'3']);
//        return response()->json('Director Accepted');
//    }

    public function manager_note(Request $request, Verification $verification)
    {
        $verification->update(['manager_note' => $request->manager_note]); //Accepted
        return response()->json('Manager Note: ' . $request->manager_note);
    }

    public function member_message(Request $request, Verification $verification)
    {
        $verification->update(['member_message' => $request->member_message]); //Accepted
        return response()->json('Member Message: ' . $request->member_message);
    }

    public function id_card_choose_by_member(Request $request, IdCard $idCard)
    {
//        return $request->acception;
        if ($request->acception)
            $idCard->update(['status' => '6']); //Accepted
        else
            $idCard->update(['status' => '5']); //Decline
        return response()->json('Status Updated Successfully');
    }

    public function accounts_verify(IdCard $idCard)
    {
        $idCard->update(['status' => '7']); //Paid
        return response()->json('Accounts Verified Successfully');
    }

    public function comment(Request $request, IdCard $idCard)
    {
        $idCard->update(['member_comment' => $request->comment, 'status' => '1']);
        return response()->json('Comment Created Successfully');
    }

    public function delete_comment(IdCard $idCard)
    {
        $idCard->update(['member_comment' => '']);
        return response()->json('Comment Removed Successfully');
    }

    public function update_id_card_number(Request $request, IdCard $idCard)
    {
        $idCard->update(['id_card_number' => $request->id_card_number, 'status' => '8']); //Processing
        return response()->json('id_card_number ID Card Successfully');
    }

    public function update_proximity_number(Request $request, IdCard $idCard)
    {
        $idCard->update(['proximity_number' => $request->proximity_number, 'status' => '9']);
        return response()->json('Commented ID Card Successfully');
    }

    public function update_delivered(Request $request, IdCard $idCard)
    {
        $idCard->update(['delivery_date' => $request->delivery_date, 'status' => '10']);
        return response()->json('Delivered ID Card Successfully');
    }

    public function verification(IdCard $idCard)
    {
//        foreach ($idCard->members as $member) {
//            $verification = Verification::firstOrCreate(['member_id' => $member->id, 'is_approved' => 0]);
//            if (!$verification->id_cards->contains($idCard->id)) {
//                $verification->id_cards()->attach($idCard);
//                $verification->update(['verification_date' => date("Y-m-d")]);
//            }
//        }
        $verification = Verification::firstOrCreate(['member_id' => $idCard->member_id, 'is_approved' => 0, 'form_year' => $idCard->form_year]);
        if (!$verification->id_cards->contains($idCard->id)) {
            $verification->id_cards()->attach($idCard);
            $verification->update(['verification_date' => date("Y-m-d"), 'form_year' => $idCard->form_year]);
        }

        $idCard->update(['status' => '2']);
        return response()->json('ID Card Verified Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Vanguard\IdCard $idCard
     * @return \Illuminate\Http\Response
     */
    public function destroy(IdCard $idCard)
    {
        $idCard->members()->sync([]);
        $idCard->delete();
        return response()->json('ID Card Deleted Successfully');
    }

    public function getActiveYears()
    {
        return IdCardFormYear::where('is_active', 1)->pluck('year')->toArray();

    }
}

<?php

namespace Vanguard\Http\Controllers\Api;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use League\CommonMark\Extension\FrontMatter\Output\RenderedContentWithFrontMatter;
use Vanguard\CompanyOwner;
use Vanguard\Country;
use Vanguard\GatePass;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Requests\Member\MemberDetailRequest;
use Vanguard\Http\Requests\Member\MemberRequest;
use Vanguard\Http\Resources\MemberDetailResource;
use Vanguard\Http\Resources\MemberResource;
use Vanguard\Member;
use Vanguard\MemberAddress;
use Vanguard\MemberDetail;
use Vanguard\RenewMember;
use Vanguard\RenewMemberAddress;
use Vanguard\Repositories\Member\MemberRepository;
use Vanguard\Repositories\MemberDetail\MemberDetailRepository;
use Vanguard\Support\Enum\MemberStatus;
use Vanguard\Support\Enum\UserStatus;

class MembersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $member;

    public function __construct(MemberDetailRepository $member)
    {
        $this->member = $member;
    }

    public function index()
    {
        if (!Cache::has('members')) {
            Cache::remember('members', now()->addMinutes(60*24), function () {
                $members = Member::with(['member_detail', 'privileges', 'signatory', 'head_office', 'voter'])->orderBy('created_at', 'desc')->get();
//            ->select('members.id','members.username','members.email')
//            ->get();
//        return $members = Member::active()->pluck('members.id','members.username');
//        return $members;
                return MemberResource::collection($members);
//        return new MemberResource($members);
            });
        }
        return Cache::get('members');
    }

    public function due_members()
    {
        $members = Member::duePayment()->orderBy('created_at', 'desc')->get();
        return MemberResource::collection($members);
    }

    public function getAllVerifiedOrganizationName()
    {
        return Member::whereNotNull('organization_name')->verified()->with('company_owners')->get(['id', 'username', 'organization_name']);
    }

    public function getAllOrganizationName()
    {
//        return Member::whereNotNull('organization_name')->groupBy('organization_name')->pluck('organization_name');
//        return Member::whereNotNull('organization_name')->whereStatus('Active')->with('company_owners')->get(['id','username','organization_name']);//->select('username','organization_name');
        return Member::whereNotNull('organization_name')->active()->with(['company_owners', 'member_address'])->get(['id', 'username', 'organization_name']);//->select('username','organization_name');

    }

    public function getAllOrganizationNameForElection()
    {
        return Member::whereNotNull('organization_name')->active()->
        with([
            'member_detail' => function ($query) {
                $query->select('member_details.id', 'member_id', 'place_of_enlistment', 'tin_number', 'attach_e_tin_certificate');
            },
            'company_owners' => function ($query) {
                $query->select('company_owners.id', 'member_id', 'name', 'designation', 'email', 'mobile_no', 'attach_signature', 'attach_photograph')->orderBy('name', 'DESC');
            },
            'head_office' => function ($query) {
                $query->select( 'member_id', 'member_address_type', 'telephone_no', 'fax_no', 'address');
            }
        ])->get(['members.id', 'username', 'organization_name']);//->select('username','organization_name');

    }

//    public function allRenewalMembers(Member $member)
//    {
//        return RenewMember::all();
//    }

    public function activeIdCard(Member $member)
    {
        return $member->id_cards()->select([
            "id_cards.id",
            "id_cards.id_card_number",
            "id_cards.card_holder_name",
            "id_cards.card_holder_designation",
            "id_cards.caab_id_no",
            "id_cards.card_holder_photograph_attachment",
            "id_cards.card_holder_signature_attachment",
            "id_cards.attachment_name",
            "id_cards.attachment_number",
            "id_cards.attachment_file",
            "id_cards.police_verification",
            "id_cards.police_verification_attachment"
        ])->where('id_cards.status', 10)->get()->makeHidden('pivot');
//        return $member->id_cards()->select(["id_cards.id","id_cards.id_card_number"])->where('id_cards.status', 10)->get()->makeHidden('pivot');
    }

    public function renewalMember(RenewMember $renewal_member)
    {
        return $renewal_member;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(MemberRequest $request)
    {
        //        $member = new Member();
//        $member->email = $request->email;
//        $member->username = $request->username;
//        $member->password = $request->password;
//        $member->status = UserStatus::ACTIVE;
//        $member->save();
        $member = ['email' => $request->email, 'username' => $request->username, 'password' => $request->password];
//        Session::put('member_data', $member);
        Cache::put('member_data', $member, now()->addMinutes(30));
        return response()->json($member);
    }

    public function save_short_member(MemberRequest $request)
    {
        $member = new Member();
        $member->username = $request->username;
        $member->email = $request->email;
        $member->password = $request->password;
        $member->status = UserStatus::ACTIVE;
        $member->organization_name = $request->organization_name;
        if ($member->save())
            $member->member_detail()->create($request->all());
        return response()->json($member);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function store(MemberDetailRequest $request)
    {
//        return $request->all();
        $member = new Member();
        $member->username = $request->username;
        $member->password = $request->password;
        $member->email = $request->email;
        $member->organization_name = $request->firm_name;
        $member->status = MemberStatus::PENDING;
        if ($member->save()) {
            $member->member_detail()->create($request->all());
            $target_dir = 'attached_images/members/' . $member->id;

            $productImage = $request->file('attach_no_of_appointed_staff');
            if (is_file($productImage)) {
                $imageUrl = $this->productImageUpload($productImage, $target_dir);
                $member->member_detail->attach_no_of_appointed_staff = $imageUrl;
            }
            $productImage = $request->file('attach_proposed_seconded_by');
            if (is_file($productImage)) {
                $imageUrl = $this->productImageUpload($productImage, $target_dir);
                $member->member_detail->attach_proposed_seconded_by = $imageUrl;
            }
            $productImage = $request->file('attach_declaration_undertaking');
            if (is_file($productImage)) {
                $imageUrl = $this->productImageUpload($productImage, $target_dir);
                $member->member_detail->attach_declaration_undertaking = $imageUrl;
            }

            $productImage = $request->file('attach_article');
            if (is_file($productImage)) {
                $imageUrl = $this->productImageUpload($productImage, $target_dir);
                $member->member_detail->attach_article = $imageUrl;
            }
            $productImage = $request->file('attach_incorporation_certificate');
            if (is_file($productImage)) {
                $imageUrl = $this->productImageUpload($productImage, $target_dir);
                $member->member_detail->attach_incorporation_certificate = $imageUrl;
            }
            $productImage = $request->file('attach_trade_license');
            if (is_file($productImage)) {
                $imageUrl = $this->productImageUpload($productImage, $target_dir);
                $member->member_detail->attach_trade_license = $imageUrl;
            }
            $productImage = $request->file('attach_e_tin_certificate');
            if (is_file($productImage)) {
                $imageUrl = $this->productImageUpload($productImage, $target_dir);
                $member->member_detail->attach_e_tin_certificate = $imageUrl;
            }
            $productImage = $request->file('attach_vat_registration_certificate');
            if (is_file($productImage)) {
                $imageUrl = $this->productImageUpload($productImage, $target_dir);
                $member->member_detail->attach_vat_registration_certificate = $imageUrl;
            }

            $productImage = $request->file('attach_ff_license_no');
            if (is_file($productImage)) {
                $imageUrl = $this->productImageUpload($productImage, $target_dir);
                $member->member_detail->attach_ff_license_no = $imageUrl;
            }
            $productImage = $request->file('attach_bank_solvency_certificate');
            if (is_file($productImage)) {
                $imageUrl = $this->productImageUpload($productImage, $target_dir);
                $member->member_detail->attach_bank_solvency_certificate = $imageUrl;
            }
            $productImage = $request->file('attach_membership_of_other_trade_organization');
            if (is_file($productImage)) {
                $imageUrl = $this->productImageUpload($productImage, $target_dir);
                $member->member_detail->attach_membership_of_other_trade_organization = $imageUrl;
            }
            $member->member_detail->mrn_no = $this->getLastID();
            $member->push();
//            $member->company_owners()->createMany($request->company_owner);
            foreach ($request->company_owner as $key => $owner) {
                $company_owner = new CompanyOwner();
                $company_owner->fill($owner);
                $company_owner->save();
                $member->company_owners()->attach($company_owner->id);
//                Start - Save All Images
                $any_image = false;
                $target_dir = 'attached_images/company_owners/' . $company_owner->id;
                $productImage = $request->file("company_owner.$key.attach_nid");
                if (is_file($productImage)) {
                    $imageUrl = $this->productImageUpload($productImage, $target_dir);
                    $company_owner->attach_nid = $imageUrl;
                    $any_image = true;
                }
                $productImage = $request->file("company_owner.$key.attach_educational_qualification");
                if (is_file($productImage)) {
                    $imageUrl = $this->productImageUpload($productImage, $target_dir);
                    $company_owner->attach_educational_qualification = $imageUrl;
                    $any_image = true;
                }
                $productImage = $request->file("company_owner.$key.attach_photograph");
                if (is_file($productImage)) {
                    $imageUrl = $this->productImageUpload($productImage, $target_dir);
                    $company_owner->attach_photograph = $imageUrl;
                    $any_image = true;
                }
                $productImage = $request->file("company_owner.$key.attach_signature");
                if (is_file($productImage)) {
                    $imageUrl = $this->productImageUpload($productImage, $target_dir);
                    $company_owner->attach_signature = $imageUrl;
                    $any_image = true;
                }
                $productImage = $request->file("company_owner.$key.attach_experience_certificate");
                if (is_file($productImage)) {
                    $imageUrl = $this->productImageUpload($productImage, $target_dir);
                    $company_owner->attach_experience_certificate = $imageUrl;
                    $any_image = true;
                }
//                End - Save All Images
                if ($any_image) {
                    $company_owner->save();
                }


//                $new_owner = new Request($owner);
//                $new_owner->merge(['member_id' => $member->id]);
//                $companyOwner = new CompanyOwnerController();
//                $companyOwner->store($new_owner);
//                if (isset($owner['email'])) {
//                    $company_owner = CompanyOwner::create($owner);
//                    $company_owner->save();
//                    $member->company_owners()->create($owner);
//                    $member->refresh();
//                }
            }
//            foreach ($request->member_address as $address) {
//                if (isset($address['mobile_no'])) {
//                    $member->member_address()->create($address);
//                }
//            }
//            $member->member_address()->createMany($request->member_address);

            // new code
            foreach ($request->member_address as $key => $owner) {
                $member_address = new MemberAddress;
                $member_address->fill($owner);
                $member_address->member_id = $member->id;
                $member_address->save();

                $any_image = false;
                $target_dir = 'attached_images/member_address/' . $member_address->id;
                $productImage = $request->file("member_address.$key.attach_office_tenancy_agreement");
                if (is_file($productImage)) {
                    $imageUrl = $this->productImageUpload($productImage, $target_dir);
                    $member_address->attach_office_tenancy_agreement = $imageUrl;
                    $any_image = true;
                }
                if ($any_image) {
                    $member_address->save();
                }
            }
            // END new code

//            return response()->json($member);
            return response()->json('Member Created Successfully');
        } else {
            return response()->json('Error');
        }

    }

    protected function getLastID()
    {
        $today = date('y', time());
        $get_last_id = MemberDetail::where('mrn_no', 'like', 'NM' . $today . '%')->orderBy('id', 'desc')->first();
        if ($get_last_id) {
            $last_id = $get_last_id->mrn_no;
            $last_id++;
        } else {
            $last_id = 'NM' . $today . '0001';
        }
        return $last_id;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
//        Session::forget('member_data');
//        $member = Session::get('member_data');
        $member = Cache::get('member_data');
        return response()->json($member);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        $member = Member::with(['member_detail', 'member_address', 'company_owners', 'privileges'])->findOrFail($member->id);
        return new MemberResource($member);
//        return response()->json($gate_pass);
    }

    public function notifications(Member $member)
    {
        return response()->json(['all_notifications' => $member->member_notifications,'count_notifications' => $member->member_notifications->count()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update_balance(Request $request, Member $member)
    {
        $member->update([
            'gatepass_balance' => (float)$request->amount
        ]);
        return $member->gatepass_balance;
        return response()->json('Member Balance Update Successfully');
    }

    public function update(Request $request, Member $member)
    {
//        return $request->all();
//        $request->validate([
//            'email' => 'required|email',
//            'username' => 'required'
//        ]);
//        $member->update([
//            'email' => $request->email,
//            'username' => $request->username
//        ]);
        if ($request->status == 'Renew_Done') {
            $member->renew_member->updateStatus('Done');
        } else if ($request->status == 'Verified') {
            $member->updateStatus($request->status);
        }
        $member->member_detail->fill($request->all());
        $member->push();
//        if($request->company_owner){
//            foreach ($request->company_owner as $key => $owner) {
//                $company_owner = CompanyOwner::firstOrNew(['id' => $owner['id']]);
//                $company_owner->fill($owner);
//                $company_owner->save();
//            }
//        }
        if ($request->member_address) {
            foreach ($request->member_address as $key => $owner) {
                $member_address = MemberAddress::firstOrNew(['id' => $owner['id']]);
                $member_address->fill($owner);
                $member_address->member_id = $member->id;
                $member_address->save();
                // new code
                $target_dir = 'attached_images/member_address/' . $member_address->id;
                $productImage = $request->file("member_address.$key.attach_office_tenancy_agreement");
                if (is_file($productImage)) {
                    $imageUrl = $this->productImageUpload($productImage, $target_dir);
                    $member_address->attach_office_tenancy_agreement = $imageUrl;
                }
                // END new code
                $member_address->save();
            }
        }

        $any_image = false;
        $target_dir = 'attached_images/members/' . $member->id;

        $productImage = $request->file('attach_article');
        if (is_file($productImage)) {
            $imageUrl = $this->productImageUpload($productImage, $target_dir);
            $member->member_detail->attach_article = $imageUrl;
            $any_image = true;
        }
        $productImage = $request->file('attach_incorporation_certificate');
        if (is_file($productImage)) {
            $imageUrl = $this->productImageUpload($productImage, $target_dir);
            $member->member_detail->attach_incorporation_certificate = $imageUrl;
            $any_image = true;
        }
        $productImage = $request->file('attach_trade_license');
        if (is_file($productImage)) {
            $imageUrl = $this->productImageUpload($productImage, $target_dir);
            $member->member_detail->attach_trade_license = $imageUrl;
            $any_image = true;
        }
        $productImage = $request->file('attach_e_tin_certificate');
        if (is_file($productImage)) {
            $imageUrl = $this->productImageUpload($productImage, $target_dir);
            $member->member_detail->attach_e_tin_certificate = $imageUrl;
            $any_image = true;
        }
        $productImage = $request->file('attach_vat_registration_certificate');
        if (is_file($productImage)) {
            $imageUrl = $this->productImageUpload($productImage, $target_dir);
            $member->member_detail->attach_vat_registration_certificate = $imageUrl;
            $any_image = true;
        }

        $productImage = $request->file('attach_ff_license_no');
        if (is_file($productImage)) {
            $imageUrl = $this->productImageUpload($productImage, $target_dir);
            $member->member_detail->attach_ff_license_no = $imageUrl;
            $any_image = true;
        }
        $productImage = $request->file('attach_bank_solvency_certificate');
        if (is_file($productImage)) {
            $imageUrl = $this->productImageUpload($productImage, $target_dir);
            $member->member_detail->attach_bank_solvency_certificate = $imageUrl;
            $any_image = true;
        }
        $productImage = $request->file('attach_membership_of_other_trade_organization');
        if (is_file($productImage)) {
            $imageUrl = $this->productImageUpload($productImage, $target_dir);
            $member->member_detail->attach_membership_of_other_trade_organization = $imageUrl;
            $any_image = true;
        }


        $productImage = $request->file('attach_no_of_appointed_staff');
        if (is_file($productImage)) {
            $imageUrl = $this->productImageUpload($productImage, $target_dir);
            $member->member_detail->attach_no_of_appointed_staff = $imageUrl;
            $any_image = true;
        }
        $productImage = $request->file('attach_proposed_seconded_by');
        if (is_file($productImage)) {
            $imageUrl = $this->productImageUpload($productImage, $target_dir);
            $member->member_detail->attach_proposed_seconded_by = $imageUrl;
            $any_image = true;
        }
        $productImage = $request->file('attach_declaration_undertaking');
        if (is_file($productImage)) {
            $imageUrl = $this->productImageUpload($productImage, $target_dir);
            $member->member_detail->attach_declaration_undertaking = $imageUrl;
            $any_image = true;
        }

        if ($any_image) {
            $member->push();
        }
        return response()->json('Member Updated Successfully');
        //        return $member->member_detail;
//        return back()->with('message', 'Record Updated Updated!');
    }

    public function renew(Request $request, Member $member)
    {
//        return $request->all();
//        $request->validate([
//            'email' => 'required|email',
//            'username' => 'required'
//        ]);
//        $member->update([
//            'email' => $request->email,
//            'username' => $request->username
//        ]);
        $member->renew_members()->create($request->all());
        if ($request->member_address) {
            foreach ($request->member_address as $key => $owner) {
                $member_address = RenewMemberAddress::firstOrNew(['id' => $owner['id']]);
                $member_address->fill($owner);
                $member_address->member_id = $member->id;
                $member_address->save();

                // new code
                $target_dir = 'attached_images/renew_member_address/' . $member_address->id;
                $productImage = $request->file("member_address.$key.attach_office_tenancy_agreement");
                if (is_file($productImage)) {
                    $imageUrl = $this->productImageUpload($productImage, $target_dir);
                    $member_address->attach_office_tenancy_agreement = $imageUrl;
                }
                // END new code
                $member_address->save();
            }
        }
        return response()->json('Member Renew Successfully');
        //        return $member->member_detail;
//        return back()->with('message', 'Record Updated Updated!');
    }

    public function voucher(Member $member)
    {

//        return $member->payments;

        $voucher = Member::with(
//            ['gate_pass' => function ($query) {
//            $query->select('id','member_id','master_airway_bill_no','created_at')->where('is_submit','1')->orderBy('created_at','DESC')->withSum('payments','amount');
//        }]
            ['payments' => function ($query) {
                $query->with(['paymentable:id,master_airway_bill_no', 'created_user:id,username']);
//                $query->select('id','member_id','amount','created_user_id','created_at')->orderBy('created_at','DESC')->with([
//                    'paymentable' => function (MorphTo $morphTo) {
//                        $morphTo->morphWith([
//                            GatePass::class => ['tags']
//                        ]);
//                    }]);
            }]
        )->with(['money_collections' => function ($query) {
            $query->select('id', 'member_id', 'voucher_no', 'amount', 'created_at', 'receipt_type')->where('money_collections.receipt_type', 'gate_pass')->orderBy('created_at', 'DESC');
        }])->select('id')->where('id', $member->id)->first();

//        DB::raw('DATE_FORMAT(created_at, "%d/%l/%Y %H:%i:%s") as created')
//        return $voucher = Member::join('gate_passes', 'members.id', '=', 'gate_passes.member_id')
//            ->join('money_collections', 'members.id', '=', 'money_collections.member_id')
//            ->where('gate_passes.is_submit', '1')
//            ->where('members.id', '1')
//            ->get();

        $total_withdraw = DB::table('payments')->where('member_id', '=', $member->id)->sum('amount');
        $total_deposit = DB::table('money_collections')->where('member_id', '=', $member->id)->where('receipt_type', 'gate_pass')->sum('amount');

        $record = [];
        $record['member'] = $member;
        $record['total_withdraw'] = $total_withdraw;
        $record['total_deposit'] = $total_deposit;
        $record['withdraw'] = $voucher->payments;
        $record['deposit'] = $voucher->money_collections;
//        return $record;
        return response()->json($record);
        //        return $member->member_detail;
//        return back()->with('message', 'Record Updated Updated!');
    }

    public function approveMember(Member $member)
    {
        $member->updateStatus(MemberStatus::APPROVED);
        return response('Member Approved Successfully');
    }

    public function activeMember(Member $member)
    {
        $member->updateStatus(MemberStatus::ACTIVE);
        return response('Member Activated Successfully');
    }

    public function bannedMember(Member $member)
    {
        $member->updateStatus(MemberStatus::BANNED);
        return response('Member Banned Successfully');
    }

    public function approval(Request $request, Member $member)
    {
        $request->validate([
            'attach_inspection_report' => 'file|mimes:jpeg,png,pdf,jpg,gif,svg|max:2048',
            'attach_checklist' => 'file|mimes:jpeg,png,pdf,jpg,gif,svg|max:10240'
        ]);
        if ($request->status) {
            $member->updateStatus(MemberStatus::APPROVAL);
        }
        if ($request->sub_committee_meeting_date) {
            $member->member_detail->sub_committee_meeting_date = $request->sub_committee_meeting_date;
        }
        if ($request->board_of_directors_meeting_no) {
            $member->member_detail->board_of_directors_meeting_no = $request->board_of_directors_meeting_no;
        }
        if ($request->board_of_directors_meeting_date) {
            $member->member_detail->board_of_directors_meeting_date = $request->board_of_directors_meeting_date;
            if ($member->status !== MemberStatus::ACTIVE)
                $member->member_detail->last_renew_year = date('Y', strtotime($request->board_of_directors_meeting_date));
        }

        $productImage = $request->attach_inspection_report;
        if (is_file($productImage)) {
            if (!($member->status == MemberStatus::ACTIVE || $member->status == MemberStatus::PENDING))
                $member->updateStatus(MemberStatus::INSPECTED);
            $imageUrl = $this->productImageUpload($productImage, 'attached_images/members/' . $member->id);
            $member->member_detail->attach_inspection_report = $imageUrl;
        }
        $attach_checklist = $request->attach_checklist;
        if (is_file($attach_checklist)) {
            $imageUrl = $this->productImageUpload($attach_checklist, 'attached_images/members/' . $member->id);
            $member->member_detail->attach_checklist = $imageUrl;
        }
        $member->push();
        return response()->json('Member Approved Successfully');
    }

    public function assign_privilege(Request $request, Member $member)
    {
        if ($request->privileges) {
            $member->privileges()->sync($request->privileges);
        }
        return response()->json('Privilege Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        if (count($member->payments) > 0) {
            return response()->json('Sorry, He has done Payments');
        } else if (count($member->money_collections) > 0) {
            return response()->json('Sorry, He has some Money Collection');
        } else if (count($member->gate_pass) > 0) {
            return response()->json('Sorry, He has GatePass');
        } else if (count($member->id_cards) > 0) {
            return response()->json('Sorry, He has ID Cards');
        } else if (count($member->voters) > 0) {
            return response()->json('Sorry, He was a Voter');
        } else {
            $member->member_detail()->delete();
            $member->delete();
            return response()->json('Member Deleted Successfully');
        }
    }

    public function check_company_uniqueness(Request $request)
    {
        return $company = Member::where('organization_name', $request->company_name)
            ->orWhere('username', $request->bmn)
            ->count();
    }
}

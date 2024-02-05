<?php

namespace Vanguard\Http\Controllers\Api;

use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Resources\RenewMemberResource;
use Vanguard\Member;
use Vanguard\RenewMember;
use Vanguard\RenewMemberAddress;
use Vanguard\Support\Enum\MemberStatus;
use Vanguard\Support\Enum\UserStatus;

class RenewMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $basic = RenewMember::with(['member' => function ($query) {
            $query->select('id', 'username','organization_name');

        }]);
        if ($request->filter) {

//        return $request;
            $id_cards = $basic->where('structure_change', '=', 0);
//                    if ($request->bmn_no !== 'null')
//                        $id_cards = $id_cards->whereHas('members', function ($q) use ($request) {
//                            $q->where('username', $request->bmn_no);
//                        });
//        if ($request->participant_name !== 'null') $id_cards = $id_cards->where('participant_name', 'like', '%' . $request->participant_name . '%');
            if ($request->member_id !== 'null') $id_cards = $id_cards->where('member_id', $request->member_id);
            if ($request->status !== 'null') $id_cards = $id_cards->where('status', $request->status);
            if ($request->submission_year !== 'null') $id_cards = $id_cards->where('submission_year', 'like', '%' . $request->submission_year . '%');
            $id_cards = $id_cards->orderBy('id', 'desc')->get();
            return $id_cards;
        } else {
            if ($request->member_id) {
                $renew_members = $basic->where('member_id', $request->member_id)->orderBy('id', 'desc')->get();
                $renew_members_pending_application_count = $basic->where('member_id', $request->member_id)->where('status','<>','Done')->count();
                return response()->json([
                    'renew_members' => $renew_members,
                    'pending_count' => $renew_members_pending_application_count
                ]);
            }else{
                return $basic->where('structure_change', '=', 0)->orderBy('id', 'desc')->get();
            }
        }
    }

    public function StructureMember(Request $request)
    {
        $basic = RenewMember::with(['member' => function ($query) {
            $query->select('id', 'username','organization_name');

        }]);
        if ($request->filter) {

//        return $request;
            $id_cards = $basic->where('structure_change', '=', 1);
//                    if ($request->bmn_no !== 'null')
//                        $id_cards = $id_cards->whereHas('members', function ($q) use ($request) {
//                            $q->where('username', $request->bmn_no);
//                        });
//        if ($request->participant_name !== 'null') $id_cards = $id_cards->where('participant_name', 'like', '%' . $request->participant_name . '%');
            if ($request->member_id !== 'null') $id_cards = $id_cards->where('member_id', $request->member_id);
            if ($request->status !== 'null') $id_cards = $id_cards->where('status', $request->status);
            if ($request->submission_year !== 'null') $id_cards = $id_cards->where('submission_year', 'like', '%' . $request->submission_year . '%');
            $id_cards = $id_cards->orderBy('id', 'desc')->get();
            return $id_cards;
        } else {
            if ($request->member_id) {
                $renew_members = $basic->where('member_id', $request->member_id)->where('structure_change', '=', 1)->orderBy('id', 'desc')->get();
                $renew_members_pending_application_count = $basic->where('member_id', $request->member_id)->where('structure_change', '=', 1)->where('status','<>','Done')->count();
                return response()->json([
                    'renew_members' => $renew_members,
                    'pending_count' => $renew_members_pending_application_count
                ]);
            }else{
                return $basic->where('structure_change', '=', 1)->orderBy('id', 'desc')->get();
            }
        }
    }


    public function check_renewal_fees(RenewMember $renew_member){
        return $renew_member->checkPayment();
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
        if (!ctype_print($request->attach_ff_license_no)) {
            $validated = $request->validate([
                'attach_ff_license_no' => 'mimes:jpeg,png,jpg,pdf|max:10240',
            ]);
        }
        if (!ctype_print($request->attach_trade_license)) {
            $validated = $request->validate([
                'attach_trade_license' => 'mimes:jpeg,png,jpg,pdf|max:10240',
            ]);
        }
        if (!ctype_print($request->attach_e_tin_certificate)) {
            $validated = $request->validate([
                'attach_e_tin_certificate' => 'mimes:jpeg,png,jpg,pdf|max:10240',
            ]);
        }
//        return $request;
//        $validated = $request->validate([
//            'attach_ff_license_no' => 'mimes:jpeg,png,jpg,pdf|max:10240',
//            'attach_trade_license' => 'mimes:jpeg,png,jpg,pdf|max:10240',
//            'attach_e_tin_certificate' => 'mimes:jpeg,png,jpg,pdf|max:10240',
//        ]);

        if ($request->id) {
            $renew_member = RenewMember::findOrFail($request->id);
            if ($request->status !== 'null') {
                $request['status'] = MemberStatus::ACCEPTED;
/*                if($renew_member->structure_change)
                    $request['status'] = MemberStatus::VERIFIED;
                else
                    $request['status'] = MemberStatus::APPROVAL;*/
            } else {
                $request['status'] = MemberStatus::PENDING;
            }
            $renew_member->fill($request->all());
            $renew_member->save();
        } else {
            $data = $request->all() + [
                    'status' => MemberStatus::PENDING
                ];
            $member = Member::findOrFail($request->member_id);
            $renew_member = RenewMember::create($data);

            // Save Attachment
            $any_image = false;
            $target_dir = 'attached_images/renew_members/' . $renew_member->id;
            $productImage = $request->file('attach_ff_license_no');
            if (is_file($productImage)) {
                $imageUrl = $this->productImageUpload($productImage, $target_dir);
                $renew_member->attach_ff_license_no = $imageUrl;
                $any_image = true;
            }
            $productImage = $request->file('attach_trade_license');
            if (is_file($productImage)) {
                $imageUrl = $this->productImageUpload($productImage, $target_dir);
                $renew_member->attach_trade_license = $imageUrl;
                $any_image = true;
            }
            $productImage = $request->file('attach_e_tin_certificate');
            if (is_file($productImage)) {
                $imageUrl = $this->productImageUpload($productImage, $target_dir);
                $renew_member->attach_e_tin_certificate = $imageUrl;
                $any_image = true;
            }else{
                $renew_member->attach_e_tin_certificate = $request->attach_e_tin_certificate;
            }
            if ($any_image) {
                $renew_member->save();
            }
            $renew_member->company_owners()->sync($member->company_owners);
//          $companyOwner->members()->sync($request->member_id);


        }
//        $member->renew_members()->create($data);
        if ($request->member_address) {
//            $last_renew_member = $member->renew_members()->orderBy('id', 'DESC')->first();
            foreach ($request->member_address as $key => $owner) {
                $company_owner = RenewMemberAddress::firstOrNew(['id' => $owner['id']]);
                $company_owner->fill($owner);
                $company_owner->renew_member_id = $renew_member->id;//$member->id;
                $company_owner->save();
            }
        }

        return response()->json($renew_member->id);
    }

    public function change_company_name(RenewMember $renewMember){
        if($renewMember->firm_name)
            return $renewMember->member->updateCompanyName($renewMember->firm_name);
    }
/*    public function approveMember(RenewMember $renewMember)
    {
        $renewMember->updateStatus(MemberStatus::APPROVED);
        return response('Renew Member Approved Successfully');
    }

    public function activeMember(RenewMember $renewMember)
    {
        $renewMember->updateStatus(MemberStatus::ACTIVE);
        return response('Renew Member Activated Successfully');
    }*/

    public function setCompanyStructureCharge(Request $request, RenewMember $renewMember)
    {
//        return $renewMember;
        // structure_change_charge
        $renewMember->update(['structure_change_charge'=>$request->structure_change_charge]);
        return response('Structural Charge Set Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param \Vanguard\RenewMember $renewMember
     * @return \Illuminate\Http\Response
     */
    public function show(RenewMember $renewMember)
    {
//        return $renewMember->member_detail;
//        $renewMember = RenewMember::with(['renew_member_address','member_detail'])->findOrFail($renewMember->id);
        $renewMember = RenewMember::with(['renew_member_address','contact_person'])->findOrFail($renewMember->id);
        return new RenewMemberResource($renewMember);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Vanguard\RenewMember $renewMember
     * @return \Illuminate\Http\Response
     */
    public function edit(RenewMember $renewMember)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Vanguard\RenewMember $renewMember
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RenewMember $renewMember)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Vanguard\RenewMember $renewMember
     * @return \Illuminate\Http\Response
     */
    public function destroy(RenewMember $renewMember)
    {
        if($renewMember->status == 'Pending'){
            $renewMember->company_owners()->delete();
            $renewMember->delete();
            return response()->json('Renew Member Deleted Successfully');
        }else
            return response()->json('Renew Member Status must be Pending');
    }
}

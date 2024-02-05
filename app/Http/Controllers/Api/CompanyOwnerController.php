<?php

namespace Vanguard\Http\Controllers\Api;

use Faker\Provider\Company;
use Illuminate\Http\Request;
use Vanguard\CompanyOwner;
use Vanguard\Http\Resources\CompanyOwnerResource;
use Vanguard\Member;
use Vanguard\RenewMember;

class CompanyOwnerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Member $member)
    {
//        return $member->company_owners;
        return CompanyOwnerResource::collection($member->company_owners()->orderBy('id', 'desc')->get());
    }

    public function deleted_company_owners(Member $member)
    {
//        return $renew_member->company_owners;
        return CompanyOwnerResource::collection($member->all_company_owners()->orderBy('id', 'desc')->get());
    }

    public function renew_member_company_owners(RenewMember $renew_member)
    {
//        return $renew_member->company_owners;
        return CompanyOwnerResource::collection($renew_member->company_owners()->orderBy('id', 'desc')->get());
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        return $request;
        $request->validate([
            'name' => 'required',
            'designation' => 'required',
            'attach_nid' =>       'mimes:jpeg,png,jpg,pdf|max:2048',
            'attach_educational_qualification' =>       'mimes:jpeg,png,jpg,pdf|max:2048',
            'attach_photograph' =>       'mimes:jpeg,png,jpg,pdf|max:2048',
            'attach_signature' =>       'mimes:jpeg,png,jpg,pdf|max:2048',
            'attach_experience_certificate' =>       'mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        if(is_numeric($request->id)){
            $companyOwner = CompanyOwner::findOrFail($request->id);
        }else{
            $companyOwner = new CompanyOwner();
        }


        $companyOwner->fill($request->all())->save();

        if($request->renew_member_id)
            $companyOwner->renew_members()->sync($request->renew_member_id);
        else if($request->member_id)
            $companyOwner->members()->sync($request->member_id);
//        $companyOwner->name = $request->input('name');
//        $companyOwner->save();


        $any_image = false;
        $target_dir = 'attached_images/company_owners/' . $companyOwner->id;
        $productImage = $request->file("attach_nid");
        if (is_file($productImage)) {
            $imageUrl = $this->productImageUpload($productImage, $target_dir);
            $companyOwner->attach_nid = $imageUrl;
            $any_image = true;
        }
        $productImage = $request->file("attach_educational_qualification");
        if (is_file($productImage)) {
            $imageUrl = $this->productImageUpload($productImage, $target_dir);
            $companyOwner->attach_educational_qualification = $imageUrl;
            $any_image = true;
        }
        $productImage = $request->file("attach_photograph");
        if (is_file($productImage)) {
            $imageUrl = $this->productImageUpload($productImage, $target_dir);
            $companyOwner->attach_photograph = $imageUrl;
            $any_image = true;
        }
        $productImage = $request->file("attach_signature");
        if (is_file($productImage)) {
            $imageUrl = $this->productImageUpload($productImage, $target_dir);
            $companyOwner->attach_signature = $imageUrl;
            $any_image = true;
        }
        $productImage = $request->file("attach_experience_certificate");
        if (is_file($productImage)) {
            $imageUrl = $this->productImageUpload($productImage, $target_dir);
            $companyOwner->attach_experience_certificate = $imageUrl;
            $any_image = true;
        }
        if ($any_image) {
            $companyOwner->save();
        }
        return response()->json($companyOwner);

    }

    /**
     * Display the specified resource.
     *
     * @param  \Vanguard\CompanyOwner  $companyOwner
     * @return \Illuminate\Http\Response
     */
    public function show(CompanyOwner $companyOwner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Vanguard\CompanyOwner  $companyOwner
     * @return \Illuminate\Http\Response
     */
    public function edit(CompanyOwner $companyOwner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Vanguard\CompanyOwner  $companyOwner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CompanyOwner $companyOwner)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Vanguard\CompanyOwner  $companyOwner
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompanyOwner $companyOwner)
    {
        $companyOwner->update([
            'is_deleted'=>'1',
            'nominate_for_vote'=>'0',
            'signatory'=>'0',
            'authorized_person'=>'0'
        ]);
        return 'Successfully Delete the Company Owner';
    }

    public function activate_company_owners(CompanyOwner $companyOwner,RenewMember $renewMember)
    {
        $companyOwner->renew_members()->detach($renewMember['id']);
        $companyOwner->members()->attach($renewMember['member_id']);
        $companyOwner->update([
            'is_active'=>'1',
            'is_deleted'=>'0'
        ]);
        return 'Successfully Delete the Company Owner';
    }
}

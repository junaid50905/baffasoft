<?php

namespace Vanguard\Http\Controllers\Web\Member;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Vanguard\CompanyOwner;
use Vanguard\Country;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Requests\Member\MemberDetailRequest;
use Vanguard\Member;
use Vanguard\MemberDetail;
use Vanguard\Repositories\MemberDetail\MemberDetailRepository;
use Vanguard\Support\Enum\UserStatus;

class MemberDetailsController extends Controller
{
    /**
     * @var MemberDetailRepository
     */
    protected $memberDetail;

    public function __construct(MemberDetailRepository $memberDetail)
    {
        $this->memberDetail = $memberDetail;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $members = Member::all();
//        return $members = Member::find(2);
//        return $members = CompanyOwner::find(1)->members;
        if ($request->has('search')) {
            $members = Member::where('email', 'like', "%{$request->search}%")->orWhere('username', 'like', "%{$request->search}%")->get();
        }
        return view('member_detail.index', compact('members'));
    }

    public function change_pass(Request $request, Member $member)
    {
//        return $request->all();
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);
        $member->update([
            'password' => $request->password
        ]);
        return redirect()->route('member-details.index')->with('success', 'Password Changed');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        return $value = Cache::get('member_data');
        $member = ['email' => 'sanaulla.ict@gmail.com', 'username' => 'sanaulla.ict', 'password' => 'sanaulla.ict@gmail.com'];
        Session::put('member_data', $member);
        if (Session::has('member_data')) {
            $member_data = Session::get('member_data');
            $countries = Country::select('id', 'name')->get();
            return view('member_detail.new', compact('member_data', 'countries'));
        } else {
            return redirect('/')->withErrors('Input Again');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(MemberDetailRequest $request)
    {
        Session::forget('member_data');
//        return $request->except(['_token']);
//        return $request->company_owner;
//        $memberDetails =  MemberDetail::create($request->except(['_token']));
        $member = new Member();
        $member->username = $request->username;
        $member->password = $request->password;
        $member->email = $request->email;
        $member->status = UserStatus::UNCONFIRMED;
        if ($member->save()) {
            $member->member_detail()->create($request->all());
            foreach ($request->company_owner as $owner) {
                if (isset($owner['email'])) {
                    $company_owner = CompanyOwner::create($owner);
//                    $company_owner->save();
                    $member->company_owners()->attach($company_owner);
                }
            }
        } else {
            return redirect('/')->withErrors('Try Again ...');

        }

        /*
                $productImage = $request->file('attach_nid');
                if (is_file($productImage)) {
                    $target_dir = 'attached_images/members/' . $memberDetails->id . '/';
                    $imageUrl = $this->productImageUpload($productImage, $target_dir);
                    $memberDetails->attach_nid = $imageUrl;
                }
                $productImage = $request->file('attach_no_of_appointed_staff');
                if (is_file($productImage)) {
                    $target_dir = 'attached_images/members/' . $memberDetails->id . '/';
                    $imageUrl = $this->productImageUpload($productImage, $target_dir);
                    $memberDetails->attach_no_of_appointed_staff = $imageUrl;
                }
                $productImage = $request->file('attach_proposed_by_signature_of_seconder');
                if (is_file($productImage)) {
                    $target_dir = 'attached_images/members/' . $memberDetails->id . '/';
                    $imageUrl = $this->productImageUpload($productImage, $target_dir);
                    $memberDetails->attach_proposed_by_signature_of_seconder = $imageUrl;
                }
                $productImage = $request->file('attach_seconded_by_signature');
                if (is_file($productImage)) {
                    $target_dir = 'attached_images/members/' . $memberDetails->id . '/';
                    $imageUrl = $this->productImageUpload($productImage, $target_dir);
                    $memberDetails->attach_seconded_by_signature = $imageUrl;
                }
                $productImage = $request->file('attach_trade_license');
                if (is_file($productImage)) {
                    $target_dir = 'attached_images/members/' . $memberDetails->id . '/';
                    $imageUrl = $this->productImageUpload($productImage, $target_dir);
                    $memberDetails->attach_trade_license = $imageUrl;
                }
                $productImage = $request->file('attach_e_tin_certificate');
                if (is_file($productImage)) {
                    $target_dir = 'attached_images/members/' . $memberDetails->id . '/';
                    $imageUrl = $this->productImageUpload($productImage, $target_dir);
                    $memberDetails->attach_e_tin_certificate = $imageUrl;
                }
                $productImage = $request->file('attach_bank_solvency_certificate');
                if (is_file($productImage)) {
                    $target_dir = 'attached_images/members/' . $memberDetails->id . '/';
                    $imageUrl = $this->productImageUpload($productImage, $target_dir);
                    $memberDetails->attach_bank_solvency_certificate = $imageUrl;
                }
                $productImage = $request->file('attach_vat_registration_certificate');
                if (is_file($productImage)) {
                    $target_dir = 'attached_images/members/' . $memberDetails->id . '/';
                    $imageUrl = $this->productImageUpload($productImage, $target_dir);
                    $memberDetails->attach_vat_registration_certificate = $imageUrl;
                }
                $productImage = $request->file('attach_photograph');
                if (is_file($productImage)) {
                    $target_dir = 'attached_images/members/' . $memberDetails->id . '/';
                    $imageUrl = $this->productImageUpload($productImage, $target_dir);
                    $memberDetails->attach_photograph = $imageUrl;
                }
                $productImage = $request->file('attach_id_card_or_passport');
                if (is_file($productImage)) {
                    $target_dir = 'attached_images/members/' . $memberDetails->id . '/';
                    $imageUrl = $this->productImageUpload($productImage, $target_dir);
                    $memberDetails->attach_id_card_or_passport = $imageUrl;
                }
                $memberDetails->save();
        //        return $memberDetails;*/
//        return redirect()->back()->with('data', $memberDetails);
        return redirect('/')->with('success', 'Member Details Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param \Vanguard\MemberDetail $memberDetail
     * @return \Illuminate\Http\Response
     */
    public function show(MemberDetail $memberDetail)
//    public function show($id)
    {
//        return $this->memberDetail->find($id);
        return $memberDetail;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Vanguard\MemberDetail $memberDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(MemberDetail $memberDetail)
    {
        $member_id = 10;
        return view('member_detail.edit', compact('member_id', 'memberDetail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Vanguard\MemberDetail $memberDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MemberDetail $memberDetail)
    {
        $memberDetail->update([
            'form_submit_date' => $request->form_submit_date,
//            'firm_name' => $request->firm_name
        ]);

        return redirect()->route('member-details.index')->with('success', 'Updated Successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param \Vanguard\MemberDetail $memberDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(MemberDetail $memberDetail)
    {
        $memberDetail->delete();
        return redirect()->route('member-details.index')->with('success', 'Deleted Successfully');

    }
}

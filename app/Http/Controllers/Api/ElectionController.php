<?php

namespace Vanguard\Http\Controllers\Api;

use Illuminate\Http\Request;
use Vanguard\Election;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Resources\ElectionResource;
use Vanguard\Member;
use Vanguard\Support\Enum\MemberStatus;
use Vanguard\Voter;

class ElectionController extends Controller
{
    private $active_election;

    public function __construct()
    {
        $active_election = Election::where('status','Active')->first();
        $this->active_election = $active_election;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        return $this->active_election;
//        return new ElectionResource($this->active_election);
        return ElectionResource::collection(Election::all());

    }

    public function casting_report()
    {
        $election = Election::findOrFail($this->active_election->id);
        $total_voter = $election->voters->where('final_list', 1)->count();
        $total_casting = $election->voters->where('final_list', 1)->where('vote_cast', 1)->count();
        $dhaka_voter = $election->voters->where('final_list', 1)->where('voter_location', 'Dhaka')->count();
        $dhaka_casting = $election->voters->where('final_list', 1)->where('voter_location', 'Dhaka')->where('vote_cast', 1)->count();
        $chattogram_casting = $election->voters->where('final_list', 1)->where('voter_location', 'Chattogram')->where('vote_cast', 1)->count();
        $total = [
            'total_voter' => $total_voter,                                      // 300
            'total_casting' => $total_casting,                                  // 190
            'total_non_casting' => (int)$total_voter - (int)$total_casting,     // 300 - 190 = 110
            'dhaka_voter' => $dhaka_voter,                                      // 200
            'dhaka_casting' => $dhaka_casting,                                  // 110
            'dhaka_non_casting' => (int)$dhaka_voter - (int)$dhaka_casting,     // 200 - 110 = 90
            'chattogram_voter' => (int)$total_voter - (int)$dhaka_voter,        // 300 - 200 = 100
            'chattogram_casting' => $chattogram_casting,                        // 80
            'chattogram_non_casting' => (int)$total_voter - (int)$dhaka_voter - (int)$chattogram_casting // 300 - 200 - 80
        ];
        return response()->json($total);

    }

    public function index_active()
    {
        return Election::active()->get(['id', 'name']);
//        return ElectionResource::collection();

    }

    public function get_bar_code()
    {
        return Election::active()->get(['id', 'name']);
//        return ElectionResource::collection();

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
        $request->validate([
            'name' => 'required',
            'election_session' => 'required',
        ]);
        if (is_numeric($request->id)) {
            $election = Election::findOrFail($request->id);
        } else {
            $election = new Election();
        }
        $election->fill($request->all())->save();
        $target_dir = 'attached_images/elections/'. $election->id;
        $productImage = $request->file('attachment_chairman_signature');
        if (is_file($productImage)) {
            $imageUrl = $this->productImageUpload($productImage, $target_dir);
            $election->attachment_chairman_signature = $imageUrl;
            $election->save();
        }

        return response()->json($election);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        return Member::findOrFail(1)->head_office;
        $election = Election::findOrFail($id);
        $election->voters()->delete();
        $election->updateStatus(MemberStatus::VERIFIED);

        $members = Member::active()->with([
            'member_detail' => function ($query) {
                $query->select('member_id', 'place_of_enlistment','tin_number','attach_e_tin_certificate');
            },
            'voter' => function ($query) {
                $query->select('company_owners.id', 'member_id', 'name', 'designation', 'nid_no', 'email', 'mobile_no', 'attach_signature', 'attach_photograph');
            },
            'manager' => function ($query) {
                $query->select('company_owners.id', 'member_id', 'name', 'designation', 'attach_signature');
            },
            'head_office' => function ($query) {
                $query->select('member_id', 'member_address_type', 'telephone_no', 'fax_no', 'address');
            }])->get();
        foreach ($members as $member) {
//            $voter = Voter::where('member_id', $member->id)->where('election_id', $id)->first();
//            if (!$voter) {
            $voter = new Voter();
            $voter->election_id = $id;
            $voter->member_id = $member->id;
            $voter->manager_date = date("Y-m-d");
//            $voter->voter_e_tin_no = $member->
            if ($member->member_detail) {
                $voter->voter_location = $member->member_detail->place_of_enlistment;
                $voter->voter_e_tin_no = $member->member_detail->tin_number;
                $voter->voter_e_tin_attachment = $member->member_detail->attach_e_tin_certificate;
            }
            if ($member->head_office) {
                $member_address = $member->head_office;//member_address->first();//->where('nominate_for_vote',1)->first();
                $voter->voter_address = $member_address->address;
                $voter->voter_tel = $member_address->telephone_no;
                $voter->voter_fax = $member_address->fax_no;
            }
            if ($member->voter->count()) {
                $owner = $member->voter->first();//->where('nominate_for_vote',1)->first();
                $voter->company_owner_id = $owner->id;
                $voter->voter_name = $owner->name;
                $voter->voter_designation = $owner->designation;
                $voter->voter_nid_no = $owner->nid_no;
                $voter->voter_mob = $owner->mobile_no;
                $voter->voter_email = $owner->email;
                $voter->voter_signature = $owner->attach_signature;
                $voter->voter_image = $owner->attach_photograph;
            }
            if ($member->manager->count()) {
                $manager = $member->manager->first();//->where('nominate_for_vote',1)->first();
                $voter->manager_id = $manager->id;
                $voter->manager_name = $manager->name;
                $voter->manager_designation = $manager->designation;
                $voter->manager_signature = $manager->attach_signature;
            }
            $voter->save();

        }
        return $election;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $election = Election::findOrFail($id);
        return view('election.check_bar_code',compact('election'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        return $request->list;
        $election = Election::findOrFail($id);
        if($request->list == 'preliminary_list'){
            $election->updateStatus(MemberStatus::INSPECTED);
            $affectedRows = $election->voters()->where('due_list', 0)->update(array('preliminary_list' => 1));
        }else if($request->list == 'final_list'){
            $active_election = Election::where('status','Active')->count();
            if($active_election == 0){
                $all_voters = $election->voters()->with(['member' => function ($query) {
                    $query->orderBy('organization_name', 'desc');
                }])->where('preliminary_list', 1)->get();
//            $affectedRows = $election->voters()->where('preliminary_list', 1)->update(array('final_list' => 1));
                $i = '0001';
                foreach ($all_voters as $voter) {
                    $voter_number = str_pad($i++,4,"0",STR_PAD_LEFT);
//                $voter->changeStatus('final_list');
//                $voter->updateFinalList();
//                $voter->updatePreliminaryList();
                    $voter->update([
                        'final_list' => 1,
                        'voter_number' => $voter_number
                    ]);
                }
                $election->updateStatus(MemberStatus::ACTIVE);
            }else{
                return response()->json('Sorry, Multiple Election can not activated');
            }
        }else if($request->list == 'archived'){
            $election->updateStatus(MemberStatus::ARCHIVED);
            $affectedRows = $election->voters()->update(array('archived' => 1));
        }
        return response()->json('Voter Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

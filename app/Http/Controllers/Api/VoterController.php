<?php

namespace Vanguard\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Vanguard\Election;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Resources\ElectionResource;
use Vanguard\Http\Resources\VoterResource;
use Vanguard\Support\Enum\MemberStatus;
use Vanguard\Voter;

class VoterController extends Controller
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
    public function index(Request $request)
    {
        if ($request->election_id) {
            $election = Election::findOrFail($request->election_id);
//            return $request->election_id;
            $all_voters = Voter::with(['member' => function ($query) {
                $query->orderBy('organization_name', 'desc');
            }])->where('election_id', $request->election_id);
            if ($request->list) {
                if ($request->list == 'due_list') {
                    $all_voters = $all_voters->where('due_list', 1);
                } else if ($request->list == 'preliminary_list') {
                    $all_voters = $all_voters->where('preliminary_list', 1);
                } else if ($request->list == 'non_preliminary_list') {
                    $all_voters = $all_voters->where('preliminary_list', 0);
                }
            } else {
                if ($request->select_location) {
                    if ($request->select_location == 'Dhaka')
                        $all_voters = $all_voters->where('voter_location', 'Dhaka');
                    else
                        $all_voters = $all_voters->where('voter_location', '<>', 'Dhaka');
                }
                if ($request->select_voter) {
                    if ($request->select_voter == 'non_voter')
                        $all_voters = $all_voters->where('vote_cast', 0);
                    else
                        $all_voters = $all_voters->where('vote_cast', 1);
                }
//            $active_voters = [];
//            $voters = Voter::with('member')->where('election_id', $request->election_id);
//            MemberStatus::VERIFIED
                if ($election->status == MemberStatus::INSPECTED) {
//                $voters = $all_voters->where('due_list', 0)->get();//->where('preliminary_list', 1);
//                $active_voters = $all_voters->where('preliminary_list', 1)->get();
                } else if ($election->status == MemberStatus::ACTIVE) {
                    $all_voters = $all_voters->where('final_list', 1);
                    if ($request->select_location) {
                        if ($request->select_location == 'Dhaka')
                            $all_voters = $all_voters->where('voter_location', 'Dhaka');
                        else if ($request->select_location == 'Chattogram')
                            $all_voters = $all_voters->where('voter_location', 'Chattogram');
                    }
                    if ($request->select_voter) {
                        if ($request->select_voter == 'voter')
                            $all_voters = $all_voters->where('vote_cast', 1);
                        else if ($request->select_voter == 'non_voter')
                            $all_voters = $all_voters->where('vote_cast', 0);
                    }
                    $voters = $all_voters->get();

                } else if ($election->status == MemberStatus::BANNED) {
                    $all_voters = $all_voters->where('archived', 1);
                    if ($request->select_location) {
                        if ($request->select_location == 'Dhaka')
                            $all_voters = $all_voters->where('voter_location', 'Dhaka');
                        else if ($request->select_location == 'Chattogram')
                            $all_voters = $all_voters->where('voter_location', 'Chattogram');
                    }
                    if ($request->select_voter) {
                        if ($request->select_voter == 'voter')
                            $all_voters = $all_voters->where('vote_cast', 1);
                        else if ($request->select_voter == 'non_voter')
                            $all_voters = $all_voters->where('vote_cast', 0);
                    }
                }
            }
            $voters = $all_voters->get();
//            return $election->voters;
//            return Voter::all();
            return response()->json([
                'election' => new ElectionResource($election),
                'voters' => VoterResource::collection($voters),
//                'active_voters' => VoterResource::collection($active_voters)
            ]);
//            return VoterResource::collection(Voter::with('member')->where('election_id', $request->election_id)->orderBy('id', 'desc')->get());

        } else {
            return response('Please Select Election');
        }
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
            'member_id' => 'integer',
            'election_id' => 'integer'
        ]);
        $allRequest = $request->all();
        if ($request->member_id && $request->election_id) {
            if ($request->id) {
                $voter = Voter::findOrFail($request->id);
//            $voter->fill($allRequest)->save();
            } else {
                $voter = new Voter();
                $voter_count = Voter::where('election_id', $request->election_id)->where('member_id', $request->member_id)->count();
                if ($voter_count > 0) {
                    return response()->json(['message' => 'This Company is Already Applied regarding this Election'], 404);
                }
            }
            //$voter = Voter::create($allRequest);
            $voter->fill($allRequest)->save();
            return response()->json($voter);
        } else {
            return response()->json(['message' => 'Select Company & Election'], 500);
        }

//        $objetoRequest = new Request();
//        $objetoRequest->setMethod('POST');
//        $objetoRequest->request->add(['mawb'=>$allRequest['master_airway_bill_no']]);
//        $find_gate_pass = $this->check_mawb($objetoRequest);
//        if($find_gate_pass > 0){
//            $gate_pass = GatePass::where('master_airway_bill_no',$request->master_airway_bill_no)->get();
//        }else{
//        return auth()->id();
//        $allRequest['dimension'] = empty($request->dimension) ? null : json_encode($request->dimension);
        /*$allRequest['receipt_no'] = $this->getLastGatePassID();
        $member = Member::findOrFail($request->member_id);
        $allRequest['member_id'] = $member->id;
        $gate_pass = GatePass::create($allRequest);
        $gate_pass->member->updateBalance(-($request->amount));
        return response()->json($gate_pass);*/
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function show($id)
    {
//        $voter = Voter::with(['member', 'election', 'company_owner'])->findOrFail($id);
        $voter = Voter::findOrFail($id);
        return new VoterResource($voter);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($bar_code)
    {
        $voter_number = Str::of($bar_code)->substr(3, 4);
        $election = Election::findOrFail($this->active_election->id);
        return response()->json($election->voters()->voterNumber($voter_number));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function update(Request $request, $id)
    {
        $voter = Voter::findOrFail($id);
        if ($request->vote_casting_location) {
            if ($voter->vote_cast)
                return response('Already Casted From ' . $voter->vote_casting_location);
            else {
                $voter->update([
                    'vote_casting_location' => $request->vote_casting_location,
                    'vote_cast' => 1
                ]);
                return response('Casting Successfully');
            }

        } else if ($request->activation_key) {
            $voter->changeStatus($request->activation_key, $request->activation_value);
            return response('Voter Updated Successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        return $id;

    }
}

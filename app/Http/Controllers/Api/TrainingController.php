<?php

namespace Vanguard\Http\Controllers\Api;

use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Resources\TrainingResource;
use Vanguard\Training;
use Vanguard\TrainingName;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->training_name){
//            if($request->training_name){
                if ($request->start_date) {
                    $from = date($request->start_date);
                    $to = date($request->end_date);
                    $id_cards = Training::where('training_name', $request->training_name);
//                    if ($request->bmn_no !== 'null')
//                        $id_cards = $id_cards->whereHas('members', function ($q) use ($request) {
//                            $q->where('username', $request->bmn_no);
//                        });
                    if ($request->participant_name !== 'null') $id_cards = $id_cards->where('participant_name', 'like', '%' . $request->participant_name . '%');
                    if ($request->member_id !== 'null') $id_cards = $id_cards->where('member_id', $request->member_id);
                    if ($request->status !== 'null') $id_cards = $id_cards->where('status', $request->status);
                    $id_cards = $id_cards->whereBetween('created_at', [$from . " 00:00:00", $to . " 23:59:59"]);
                    $id_cards = $id_cards->orderBy('id', 'desc')->get();
                    $allTraining = $id_cards;
                }else{
                    $id_cards = Training::where('training_name', $request->training_name);
                    if ($request->member_id){
                        if ($request->member_id !== 'null')
                            $id_cards = $id_cards->where('member_id', $request->member_id);
                    }
                    $id_cards = $id_cards->orderBy('id', 'desc')->get();
                    $allTraining = $id_cards;
                }
                return TrainingResource::collection($allTraining);
//            }
//            else if($request->training_name == 'dg'){
//                return TrainingResource::collection(Training::where('training_name','dg')->orderBy('id', 'desc')->get());
//            }else if($request->training_name == 'other'){
//                return TrainingResource::collection(Training::where('training_name','other')->orderBy('id', 'desc')->get());
//            }
        }else{
            return TrainingResource::collection(Training::all());
        }
    }

    public function training_names()
    {
        $training_names = TrainingName::all();
        return $training_names;
    }

    public function check_training_name($name)
    {
        $training = TrainingName::where('training_name',$name)->first();
        return $training;
        if($training)
            return $training->visibility;
        else
            return 0;
    }

    public function update_training_name($id,$visibility)
    {
        $training = TrainingName::findOrFail($id);
        if($visibility == 1)
            $training->update(['visibility' => 1]);
        else
            $training->update(['visibility' => 0]);
        return response('Training Name Updated');
//        return $request;
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

        $request->validate([
            'member_id' => 'required',
            'director_id' => 'required',
            'participant_name' => 'required',
        ]);
        if (is_numeric($request->id)) {
            $trianing = Training::findOrFail($request->id);
        } else {
            $trianing = new Training();
        }

        $trianing->fill($request->all())->save();
        $trianing->update(['submission_year'=>date("Y")]);

        $any_image = false;
        $target_dir = 'attached_images/training/'. $trianing->id;

        $productImage = $request->file('applicant_signature');
        if (is_file($productImage)) {
            $imageUrl = $this->productImageUpload($productImage, $target_dir);
            $trianing->applicant_signature = $imageUrl;
            $any_image = true;
        }

        $productImage = $request->file('applicant_photograph_attachment');
        if (is_file($productImage)) {
            $imageUrl = $this->productImageUpload($productImage, $target_dir);
            $trianing->applicant_photograph_attachment = $imageUrl;
            $any_image = true;
        }

        $productImage = $request->file('applicant_national_id_card_attachment');
        if (is_file($productImage)) {
            $imageUrl = $this->productImageUpload($productImage, $target_dir);
            $trianing->applicant_national_id_card_attachment = $imageUrl;
            $any_image = true;
        }

        $productImage = $request->file('applicant_police_verification_attachment');
        if (is_file($productImage)) {
            $imageUrl = $this->productImageUpload($productImage, $target_dir);
            $trianing->applicant_police_verification_attachment = $imageUrl;
            $any_image = true;
        }
        if ($any_image) {
            $trianing->save();
        }
        return response()->json($trianing);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $training = Training::findOrFail($id);
        return new TrainingResource($training);
//        $gate_pass = Training::with(['payments', 'member', 'member_detail','on_behalf_of_member'])->findOrFail($id);
//        return response()->json($gate_pass);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tranning = Training::with(['tranning', 'member_id', 'participant_id', 'director_id'])->findOrFail($id);
        return new TrainingResource($tranning);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $training = Training::findOrFail($id);
        $training->update([
            'certificate_number' => $request->certificate_number,
            'caab_id_no' => $request->caab_id_no,
            'certificate_validity' => $request->certificate_validity,
            'delivery_date' => $request->delivery_date,
            'file_number' => $request->file_number,
            'updated_user_id' => $request->updated_user_id,
            'status' => 'Verified'
        ]);
        return response('Training Successfully Updated');
//        return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $training = Training::findOrFail($id);
        $training->delete();
        return response('Training Delete Successfully');

    }
}

<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voter extends Model
{
    use HasFactory;

    protected $dates = ['created_at', 'updated_at','manager_date'];

    protected $fillable = [
        'election_id',
        'member_id',
        'company_owner_id',
        'voter_name',
        'voter_designation',
        'voter_e_tin_no',
        'voter_e_tin_attachment',
        'voter_nid_no',
        'voter_address',
        'voter_tel',
        'voter_mob',
        'voter_fax',
        'voter_email',
        'voter_signature',
        'voter_image',
        'voter_location',
        'vote_casting_location',
        'vote_cast',

        'manager_id',
        'manager_signature',
        'manager_name',
        'manager_designation',
        'manager_date',

        'due_list',
        'preliminary_list',
        'final_list',
        'voter_number',
        'archived',

        'created_at',
        'updated_at'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
    public function election()
    {
        return $this->belongsTo(Election::class, 'election_id');
    }
    public function company_owner()
    {
        return $this->belongsTo(CompanyOwner::class, 'company_owner_id');
    }

    public function changeStatus($activation_key,$status = 1){
        $this->update([
            $activation_key => $status
        ]);
    }
    public function scopeVoterNumber($query,$voter_number)
    {
        return $query->whereNotNull('voter_number')->where('voter_number',$voter_number)->first();
    }
//    public function updatePreliminaryList($status = 1){
//        $this->update([
//            'preliminary_list' => $status
//        ]);
//    }
//    public function updateFinalList($status = 1){
//        $this->update([
//            'final_list' => $status
//        ]);
//    }

}

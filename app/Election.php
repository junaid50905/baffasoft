<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vanguard\Support\Enum\MemberStatus;

class Election extends Model
{
    use HasFactory;
    protected $dates = ['created_at', 'updated_at','election_date','nomination_from_submission_deadline'];

    protected $fillable = [
        'name',
        'election_session',
        'election_date',
        'nomination_from_submission_deadline',
        'status',
        'chairman_name',
        'attachment_chairman_signature',
        'created_at',
        'updated_at'
    ];

    public function scopeActive($query)
    {
        return $query->where('elections.status',MemberStatus::ACTIVE);
    }
    //Different Status: Pending, Verified, Inspected, Active, Banned
    public function updateStatus($status = MemberStatus::PENDING){
        $this->update([
            'status' => $status
        ]);
    }
    public function voters()
    {
        return $this->hasMany(Voter::class)->with('member');
    }
}

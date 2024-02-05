<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyOwner extends Model
{
    use HasFactory;

    protected $fillable = ['name','designation','nid_no','educational_qualification','mobile_no','email','nationality_id','experience_year','nominate_for_vote','signatory','authorized_person','is_active','is_deleted'];

    /**
     * The roles that belong to the user.
     */
    public function members()
    {
        return $this->belongsToMany(Member::class);
    }

    public function scopeActive($query)
    {
        return $query->where('company_owners.is_deleted','0');
    }

    public function renew_members()
    {
        return $this->belongsToMany(RenewMember::class);
    }

    public function nationality()
    {
        return $this->belongsTo(Country::class,'nationality_id');
    }

}

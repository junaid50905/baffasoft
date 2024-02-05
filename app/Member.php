<?php

namespace Vanguard;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Mail;
use Vanguard\Events\User\RequestedPasswordResetEmail;
use Vanguard\Presenters\Traits\Presentable;
use Vanguard\Presenters\MemberPresenter;
use Vanguard\Services\Auth\TwoFactor\Authenticatable as TwoFactorAuthenticatable;
use Vanguard\Services\Auth\TwoFactor\Contracts\Authenticatable as TwoFactorAuthenticatableContract;
use Vanguard\Support\Enum\MemberStatus;

class Member extends Authenticatable implements TwoFactorAuthenticatableContract, MustVerifyEmail
{
    use TwoFactorAuthenticatable,
        CanResetPassword,
        Presentable,
        Notifiable,
        HasApiTokens,
        HasFactory;

    protected $presenter = MemberPresenter::class;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'members';

    protected $dates = ['birthday'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'username', 'first_name', 'last_name', 'phone', 'avatar','organization_name',
        'address', 'country_id', 'birthday', 'status', 'remember_token', 'email_verified_at','gatepass_balance'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Always encrypt password when it is updated.
     *
     * @param $value
     * @return string
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function setBirthdayAttribute($value)
    {
        $this->attributes['birthday'] = trim($value) ?: null;
    }

    public function gravatar()
    {
        $hash = hash('md5', strtolower(trim($this->attributes['email'])));

        return sprintf("https://www.gravatar.com/avatar/%s?size=150", $hash);
    }

    public function isUnconfirmed()
    {
        return $this->status == MemberStatus::UNCONFIRMED;
    }

    public function scopeActive($query)
    {
        return $query->where('members.status',MemberStatus::ACTIVE);
    }
    public function scopeDuePayment($query)
    {
        return $query->with(['member_detail'])
            ->whereHas('member_detail', function($q){
                $q->where('last_renew_year', '<', date('Y'));
            });
    }

    public function scopeVerified($query)
    {
        return $query->where('members.status',MemberStatus::APPROVED);
    }

    public function isActive()
    {
        return $this->status == MemberStatus::ACTIVE;
    }

    public function isBanned()
    {
        return $this->status == MemberStatus::BANNED;
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function member_detail()
    {
        return $this->hasOne(MemberDetail::class);
    }

    public function member_notifications()
    {
        return $this->hasMany(MemberNotification::class);
    }
    public function renew_members()
    {
        return $this->hasMany(RenewMember::class);
    }
    public function renew_member()
    {
        return $this->hasOne(RenewMember::class)->latestOfMany();
    }
    public function gate_pass()
    {
        return $this->hasMany(GatePass::class);
    }
    public function voters()
    {
        return $this->hasMany(Voter::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function money_collections()
    {
        return $this->hasMany(MoneyCollection::class);
    }

    public function id_card_records()
    {
        return $this->hasMany(IdCardRecord::class);
    }

    public function id_card_requests()
    {
        return $this->hasMany(IdCardRequest::class);
    }

    public function member_address()
    {
        return $this->hasMany(MemberAddress::class);
    }
    public function head_office()
    {
        return $this->hasOne(MemberAddress::class)->where('member_address_type','register');
    }
    public function branch_office()
    {
        return $this->hasOne(MemberAddress::class)->where('member_address_type','branch');
    }
    public function warehouse()
    {
        return $this->hasOne(MemberAddress::class)->where('member_address_type','current');
    }

    public function all_company_owners()
    {
        return $this->belongsToMany(CompanyOwner::class)->withTimestamps();
    }

    public function company_owners()
    {
        return $this->belongsToMany(CompanyOwner::class)->active()->withTimestamps();
    }

    public function voter()
    {
        return $this->belongsToMany(CompanyOwner::class)->where('is_active',1)->where('nominate_for_vote',1);
    }

    public function signatory()
    {
        return $this->belongsToMany(CompanyOwner::class)->where('signatory',1);
    }

    public function manager()
    {
        return $this->belongsToMany(CompanyOwner::class)->where('authorized_person',1);
    }

    public function company_owner()
    {
        return $this->belongsToMany(RenewMember::class)->latestOfMany();
//        return $this->belongsToMany(CompanyOwner::class)->where('nominate_for_vote',1)->first();
    }

    public function id_cards()
    {
        return $this->belongsToMany(IdCard::class)->withTimestamps();
    }

    public function member_id_cards()
    {
        return $this->hasMany(IdCard::class);
    }

    public function id_card_cancels()
    {
        return $this->hasManyThrough(IdCardCancel::class,IdCard::class);
    }

    public function id_card_reissues()
    {
        return $this->hasManyThrough(IdCardReissue::class,IdCard::class);
    }

    public function verifications()
    {
        return $this->hasMany(Verification::class)->with('id_cards')->orderBy('id','DESC');
//        return $this->belongsToMany(Verification::class)->withTimestamps();
    }

    public function privileges()
    {
        return $this->belongsToMany(Privilege::class)->withTimestamps();
    }

    public function check_privilege($privilege)
    {
        return $this->privileges->contains('name',$privilege);
    }

    public function updateBalance($recent_balance){
        $total_balance = (float)$this->gatepass_balance + (float)$recent_balance;
        $this->update([
            'gatepass_balance' => $total_balance
        ]);
    }
//    Pending -> Verified -> Inspected -> Wait For Approval -> Admin Approval -> Paid -> Active
    public function updateStatus($status = MemberStatus::PENDING){
        if($status == MemberStatus::APPROVED){
            if($this->status == MemberStatus::APPROVAL){
                $last_member_id = Member::select(DB::raw("cast(username AS UNSIGNED) as username"))->where('status','Active')->orderBy('username')->pluck('username')->last();
                $this->update([
                    'username' => (int)$last_member_id + 1
                ]);
            }
        }
            $this->update([
                'status' => $status
            ]);
    }

    public function updateCompanyName($firm_name){
        $firm_name_exist = Member::where('organization_name',$firm_name)->count();
        if($firm_name_exist == 0) {
            $this->update([
                'organization_name' => $firm_name
            ]);
            return 'Organization Name Successfully Changed';
        }
        else
            return 'Organization Name Already Exist';
    }





    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        Mail::to($this)->send(new \Vanguard\Mail\ResetPassword($token));

        event(new RequestedPasswordResetEmail($this));
    }
}

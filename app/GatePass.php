<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GatePass extends Model
{
//    protected $connection = 'mysql_archived';
    protected $dates = ['created_at', 'updated_at','date'];
//    protected $appends = ['payment'];
//
//    public function getPaymentAttribute()
//    {
//        return 'Hello';
//    }
    protected $fillable = [
        'receipt_no',
        'master_airway_bill_no',
        'contents',
        'weight',
        'flight_no',
        'destination',
        'routing',
        'bmn',
        'member',
        'member_id',
        'on_behalf_of_member',
        'on_behalf_of_member_id',
        'shipper_invoice_no',
        'date',
        'cargo_bound_for',
        'agent_name',
        'agent_id_no',
        'vehicle_no',
        'vehicle_date_of_entry',
        'vehicle_time_of_entry',
        'accepted_of_cargo',
        'special_cargo',
        'no_of_piece',
        'gross_weight',
        'dimensioni',
        'dimensionii',
        'dimensioniii',
        'dimensioniv',
        'dimensionv',
        'dimensionvi',
        'cbm',
        'vwt',
        'chargeable_weight',
        'weight_taken_date_time',
        'is_submit',
        'created_user_id',
        'created_user_name',
        'updated_user_id',
        'is_active',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by'
    ];
    use HasFactory;

    public function payments()
    {
        return $this->morphMany(Payment::class, 'paymentable');
    }

    public function payment_length(){
        return $this->payments;
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function created_user()
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }

    public function updated_user()
    {
        return $this->belongsTo(User::class, 'updated_user_id');
    }

    public function on_behalf_of_member()
    {
        return $this->belongsTo(Member::class, 'on_behalf_of_member_id');
    }

    public function member_detail()
    {
        return $this->hasOneThrough(MemberDetail::class, Member::class,'id','member_id','member_id','id');
    }

    public function SetUpdatedUserID($id){
        $this->update([
            'updated_user_id' => $id
        ]);
    }

}

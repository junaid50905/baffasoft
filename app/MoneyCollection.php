<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoneyCollection extends Model
{
    use HasFactory;
//    protected $connection = 'mysql_archived';
    protected $dates = ['created_at', 'updated_at','transaction_date','payment_chq_date'];
    protected $fillable = [
        'member_id',
        'member_no',
        'member_name',
        'payment_type',
        'payment_chq_no',
        'payment_chq_date',
        'payment_bank',
        'voucher_no',
        'receipt_type',
        'receipt_year',
        'receipt_month',
        'receipt_description',
        'amount',
        'transaction_date',
        'status',
        'created_at',
        'updated_at',
        'created_user_id',
        'created_user_name',
        'updated_user_id',
    ];


//    public static function boot()
//    {
//        parent::boot();
//        self::saved(function($model){
//            if ( ! $model->isValid()) {
//                return false;
//            }else{
//                $model->member->update([
//                    'gatepass_balance'=>$model->amount
//                ])
//            }
//        });
//    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }

    public function money_receipt_type()
    {
        return $this->belongsTo(MoneyReceiptType::class, 'receipt_type','code');
    }



}

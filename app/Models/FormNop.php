<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormNop extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'nop_id';

    protected $guarded = [];

    // protected $appends = ['GLAccount'];

    public function getAmount()
    {
        return $this->belongsTo(Amount::class,'amount_id','amount_id');
    }

    public function getPurpay()
    {
        return $this->belongsTo(PurposePayment::class,'purpay_id','purpay_id');
    }

    public function proposals()
    {
        return $this->belongsTo(Proposal::class,'prop_id','prop_id');
    }

}

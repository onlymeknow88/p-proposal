<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Amount extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'amount_id';

    protected $guarded = [];

    protected $appends = ['GLAccount','CcowName','BudgetName'];

    public function gl_acc()
    {
        return $this->belongsTo(GLAccount::class, 'gl_acc_id','gl_acc_id');
    }

    public function getGLAccountAttribute()
    {
        return $this->gl_acc['gl_account'];
    }

    public function getCcowNameAttribute()
    {
        return $this->gl_acc['CcowName'];
    }

    public function getBudgetNameAttribute()
    {
        return $this->gl_acc['BudgetName'];
    }
}

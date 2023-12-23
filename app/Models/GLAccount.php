<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GLAccount extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'gl_acc_id';

    protected $table = 'gl_accs';

    protected $guarded = [];

    protected $appends = ['CostCenter','CcowName','BudgetName'];

    public function ccow()
    {
        return $this->belongsTo(Ccow::class, 'ccow_id', 'ccow_id');
    }

    public function getCostCenterAttribute()
    {
        return $this->ccow['cost_center'];
    }

    public function getCcowNameAttribute()
    {
        return $this->ccow['ccow_name'];
    }

    public function getBudgetNameAttribute()
    {
        return $this->ccow->budget['budget_name'];
    }
}

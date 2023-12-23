<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Budget extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'budget_id';

    protected $guarded = [];

    protected $appends = ['CcowName'];

    public function ccow()
    {
        return $this->belongsTo(Ccow::class, 'ccow_id', 'ccow_id');
    }

    public function getCcowNameAttribute()
    {
        return $this->ccow['ccow_name'];
    }

}

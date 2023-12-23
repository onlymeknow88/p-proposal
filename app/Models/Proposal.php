<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proposal extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'prop_id';

    protected $guarded = [];

    protected $appends = ['hasNameStatus','BudgetName','AreaName'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function gethasNameStatusAttribute()
    {
        $status = $this->status;
        switch ($status) {
            case 1:
                return 'Waiting for Approval';
                break;
            // case 2:
            //     return 'In Review';
            //     break;
            case 3:
                return 'Approved';
                break;
            case 4:
                return 'Return';
                break;
            case 5:
                return 'Rejected';
                break;
            // case 6:
            //     return 'Deleted';
            //     break;
            default:
                return 'Waiting for Approval';
                break;
        }
    }

    public function budget()
    {
        return $this->belongsTo(Budget::class, 'budget_id','budget_id');
    }

    public function getBudgetNameAttribute()
    {
        return $this->budget['budget_name'];
    }

    public function hasFile()
    {
        return $this->hasMany(UploadFile::class, 'prop_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id','area_id');
    }
    public function getAreaNameAttribute()
    {
        return $this->area['area_name'];
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ccow extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'ccow_id';

    protected $guarded = [];

    public function budget()
    {
        return $this->belongsTo(Budget::class, 'ccow_id', 'ccow_id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalMemo extends Model
{
    use HasFactory;

    protected $primaryKey = 'memo_id';

    protected $guarded = [];

}

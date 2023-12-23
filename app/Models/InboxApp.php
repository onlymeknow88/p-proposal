<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InboxApp extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "inbox_apprs";

    protected $guarded = [];
}

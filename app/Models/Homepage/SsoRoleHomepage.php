<?php

namespace App\Models\Homepage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SsoRoleHomepage extends Model
{
    use HasFactory;

    protected $connection = "mysql_homepage";

    protected $table = "user_sso_roles";

    protected $primaryKey = "id";

    public function userHomepage()
    {
        return $this->belongsTo(UserHomepage::class, 'id', 'user_id');
    }
}

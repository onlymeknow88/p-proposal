<?php

namespace App\Models\Homepage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHomepage extends Model
{
    use HasFactory;

    protected $connection = "mysql_homepage";

    protected $table = "users";

    protected $primaryKey = "id";

    protected $appends = ['IsDeptHead', 'IsDivHead', 'IsRoleGroupSso', 'IsLoginSSO'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function employee_homepage()
    {
        return $this->belongsTo(EmployeeHomepage::class, 'emp_id', 'emp_id');
    }

    public function sso_role()
    {
        return $this->belongsTo(SSORoleHomepage::class, 'id', 'user_id');
    }

    public function getIsDeptHeadAttribute()
    {
        return $this->employee_homepage['is_department_head'];
    }

    public function getIsDivHeadAttribute()
    {
        return $this->employee_homepage['is_division_head'];
    }

    public function getIsRoleGroupSsoAttribute()
    {
        return $this->sso_role['role_group_proposal'] ??0;
    }

    public function getIsLoginSSOAttribute()
    {
        return $this->sso_role['login_sso_app'] ?? 0;
    }
}

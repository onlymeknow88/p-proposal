<?php

namespace App\Models\Homepage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeHomepage extends Model
{
    use HasFactory;

    protected $connection = "mysql_homepage";

    protected $table = "employee";

    protected $primaryKey = "emp_id";
}

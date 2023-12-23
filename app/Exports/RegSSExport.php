<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\RegSS;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class RegSSExport implements FromCollection
{
    use Exportable;

    private $date_from;
    private $date_to;

    public function __construct($date_from, $date_to)
    {
        $this->date_from = $date_from;
        $this->date_to = $date_to;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $date_from = $this->date_from;
        $date_to = $this->date_to;

        $ss = RegSS::select(
            'reg_ss.*',
            'amc_system.employee.name',
            'amc_system.master_department.dept_name as department',
            'master_lokasi.lokasi'
        )
            ->join('amc_system.employee', 'reg_ss.createdby', 'amc_system.employee.nik')
            ->join('amc_system.master_department', 'reg_ss.department', 'amc_system.master_department.dept_id')
            ->join('master_lokasi', 'reg_ss.location', 'master_lokasi.id')
            ->orderBy('reg_ss.created_at', 'desc');

        if (!empty($this->date_from) && !empty($this->date_to)) {
            $ss = $ss->whereDate('reg_ss.created_at', '>=', Carbon::parse($this->date_from)->format('Y-m-d'))
                ->whereDate('reg_ss.created_at', '<=', Carbon::parse($this->date_to)->format('Y-m-d'));
        }

        $ss = $ss->get();
        return view('ss',compact('date_from','date_to', 'ss'));
    }
}

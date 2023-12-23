<?php
namespace App\Helpers;

class Helper {

    public static function hasStatus($status)
    {
        switch($status)
        {
            case 1:
                return 'waiting for approval';
                break;
            case 2:
                return 'in review';
                break;
            case 3:
                return 'approved';
                break;
            case 4:
                return 'rejected';
                break;
            case 5:
                return 'done';
                break;
            case 6:
                return 'returned';
                break;
            default:
                return 'waiting for approval';
                break;
        }
    }


    public static function hasBudgetProgram($data)
    {
        switch($data)
        {
            case 1:
                return 'Mura Regency';
                break;
            case 2:
                return 'Kalimantan Tengah Regency';
                break;
            case 3:
                return 'Mahulu Regency';
                break;
            case 3:
                return 'Barut Regency';
                break;
            default:
                // return 'Program Bantuan';
                break;
        }
    }

    public static function formatRupiah($data)
    {
        $rupiah = "IDR " . number_format($data,0,',','.').',-';
        return $rupiah;
    }

    public static function formatWithoutRupiah($data)
    {
        $rupiah = number_format($data,0,',','.');
        return $rupiah;
    }

}

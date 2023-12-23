<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Format response.
 */
class ResponseFormatter
{
    /**
     * API Response
     *
     * @var array
     */
    protected static $response = [
        'meta' => [
            'code' => 200,
            'status' => 'success',
            'message' => null,
        ],
        'result' => null,
    ];

    /**
     * Give success response.
     */
    public static function success($data = null, $message = null)
    {
        self::$response['meta']['message'] = $message;
        self::$response['result'] = $data;

        return response()->json(self::$response, self::$response['meta']['code']);
    }

    /**
     * Give error response.
     */
    public static function error($message = null, $code = 400)
    {
        self::$response['meta']['status'] = 'error';
        self::$response['meta']['code'] = $code;
        self::$response['meta']['message'] = $message;

        return response()->json(self::$response, self::$response['meta']['code']);
    }

    public static function menu($id){
        $menu = DB::table('menus')
        ->join('permissions','permissions.menu_id','=','menus.id')
        ->select('permissions.*','menus.nama_menu','menus.level_menu','menus.no_urut','menus.link')
        ->where('permissions.role_id',$id)
        // ->where('menu.aktif','N')
        // ->orderBy('menus.no_urut')
        ->get();

        return $menu;
    }

    public static function upload($directory, $file, $filename = "", $image)
    {
        $extensi  = strtolower($file->getClientOriginalExtension());
        $filename = "{$filename}-". Str::random(10) .".{$extensi}";

        Storage::disk('public')->putFileAs("/$directory", $file, $filename);

        if (Storage::disk('public')->exists('/'.$directory.'/'.$image)) {
            Storage::disk('public')->delete('/'.$directory.'/'.$image);
        }

        return "$filename";
    }

    public static function downloader($filename, $disk = 'default') {
        if($disk == 'default') {
            $disk = config('filesystems.default');
        }
        switch(config("filesystems.disks.$disk.driver")) {
            case 'local':
                return response()->download(Storage::disk($disk)->path($filename)); //works for PRIVATE or public?!

            case 'public':
                return response()->download(Storage::disk($disk)->path($filename)); //works for PRIVATE or public?!

            case 's3':
                return redirect()->away(Storage::disk($disk)->temporaryUrl($filename, now()->addMinutes(5))); //works for private or public, I guess?

            default:
                return Storage::disk($disk)->download($filename);
        }
    }
}

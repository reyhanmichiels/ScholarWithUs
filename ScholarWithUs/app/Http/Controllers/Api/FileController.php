<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public static function manage($data)
    {
        if (! empty($data['delete_file'])) {
            Storage::delete($data['delete_file']);
        }

        $data['file']->storeAs($data['file_path'], $data['file_name']);

        $url = Storage::url($data['file_path'] . '/'. $data['file_name']);

        return $url;
    }
}

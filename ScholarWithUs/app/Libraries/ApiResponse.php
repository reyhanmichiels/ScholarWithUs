<?php 

namespace App\Libraries;

class ApiResponse
{
    public static function success($response, $code)
    {
        $data = [];
        $data['status'] = 'success';
        $data['message'] = isset($response['message']) ? $response['message'] : "";
        $data['data'] = isset($response['data']) ? $response['data'] : "";

        return response()->json($data, $code);  
    }

    public static function error($response, $code)
    {
        $data = [];
        $data['status'] = 'error';
        $data['message'] = $response ? $response : "";

        return response()->json($data, $code);  
    }
}
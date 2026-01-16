<?php
namespace App\Http\Controllers\Api;

class Response {
    public static function success($data, $message = 'OK') {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ]);
    }
}


?>
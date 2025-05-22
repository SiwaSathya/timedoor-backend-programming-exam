<?php

namespace App\Helpers;

class ApiResponse
{
    // Mengembalikan response standar sukses
    public static function success($data = null, $message = 'Operation successful', $statusCode = 200)
    {
        return response()->json([
            'status' => 'success',
            'data' => $data,
            'message' => $message
        ], $statusCode);
    }

    // Mengembalikan response standar error
    public static function error($message = 'Something went wrong', $statusCode = 400)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $statusCode);
    }
}

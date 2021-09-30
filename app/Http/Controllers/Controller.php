<?php

namespace App\Http\Controllers;

use http\Encoding\Stream\Enbrotli;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function success($data, $code = 200)
    {
        return response()->json([
            'code' => $code,
            'message' => "Operation successful",
            'data' => $data
        ]);
    }

    public function error($message, $code = 400)
    {

        return response()->json([
            'code' => $code,
            'message' => $message,
            'data' => "",
        ], $code);

    }
}

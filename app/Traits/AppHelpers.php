<?php
/**
 * Created by PhpStorm.
 * User: desarrollador1
 * Date: 22/03/2019
 * Time: 10:04 AM
 */

namespace App\Traits;


trait  AppHelpers
{
    public function returnErrors(String $message, $data = null,int $code = 422)
    {
        return response()->json(["message" => $message, "data" => $data, "error" => true], $code);
    }

    public function returnSuccess(String $message, $data = null, int $code = 200)
    {
        return response()->json(["message" => $message, "data" => $data, "error" => false], $code);
    }
}
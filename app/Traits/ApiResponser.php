<?php
/**
 * Created by PhpStorm.
 * User: USUARIO
 * Date: 23/02/2019
 * Time: 02:04 PM
 */

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;


trait ApiResponser
{
    private function successResponse($data, $code)
    {
        return response()->json($data, $code);
    }

    protected function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    protected function showAll(Collection $collection,$code = 200)
    {
        return $this->successResponse(['data' => $collection],$code);
    }

    protected function showOne(Model $instance,$code = 200)
    {
        return $this->successResponse($instance,$code);
    }

    protected function showMessage($message,$code = 200)
    {
        return $this->successResponse(['data'=>$message],$code);
    }
}
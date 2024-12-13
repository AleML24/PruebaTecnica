<?php

namespace App\Utils;

use App\Http\Controllers\TelegramController;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ResponseFormat
{

    public static function response($code, $message, $data, $meta = null)
    {
        return response()->json(['success' => true, 'message' => $message, 'data' => $data, 'meta' => $meta], $code);
    }

    public static function exceptionResponse($e)
    {
        return response()->json(['success' => false, 'message' => $e->getMessage(), 'data' => null], $e->getCode() != 0 && $e->getCode() <= 505 ? $e->getCode() : 500);
    }

    public static function getValidatorErrorMessage($validator)
    {
        $errors = $validator->errors()->all();
        $errors = "Not valid data. " . implode(", ", $errors);
        return $errors;
    }
}

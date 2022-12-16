<?php

namespace App\Constants;

use Symfony\Component\HttpFoundation\Response;

final class Status_Responses{
    const OK = Response::HTTP_OK;
    const CREATED = Response::HTTP_CREATED;
    const BAD_REQUEST = Response::HTTP_BAD_REQUEST;
    const UNAUTHORIZED = Response::HTTP_UNAUTHORIZED;
    const FORBIDDEN = Response::HTTP_FORBIDDEN;
    const NOT_FOUND = Response::HTTP_NOT_FOUND;
    const UNPROCESSABLE_ENTITY = Response::HTTP_UNPROCESSABLE_ENTITY;
    const INTERNAL_SERVER_ERROR = Response::HTTP_INTERNAL_SERVER_ERROR;

    public static function getResponseMessages()
     {
         return [
            Status_Responses::OK => 'OK',
            Status_Responses::CREATED => 'Created',
            Status_Responses::BAD_REQUEST => 'Bad Request',
            Status_Responses::UNAUTHORIZED => 'Unauthorized',
            Status_Responses::FORBIDDEN => 'Forbidden',
            Status_Responses::NOT_FOUND => 'Not Found',
            Status_Responses::UNPROCESSABLE_ENTITY => 'Unprocessable Entity',
            Status_Responses::INTERNAL_SERVER_ERROR => 'Internal Server Error',
         ];
     }

     public static function get_response_msg($key = '')
     {
         return !array_key_exists($key, self::getResponseMessages()) ?
          " " : self::getResponseMessages()[$key];
     }
}

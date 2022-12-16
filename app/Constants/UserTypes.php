<?php 

 namespace App\Constants;

 final class UserTypes{
     const SUPER_ADMIN = 0;
     const ADMIN = 1;
     const CLIENT = 2;

     public static function getUserTypes()
     {
         return [
            UserTypes::SUPER_ADMIN => 'Super Admin',
            UserTypes::ADMIN => 'Admin',
            UserTypes::CLIENT => 'Client',
         ];
     }

     public static function getUserType($key = '')
     {
         return !array_key_exists($key, self::getUserTypes()) ?
          " " : self::getUserTypes()[$key];
     }
 }
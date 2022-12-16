<?php

 namespace App\Constants;

 final class SliderGroups{
     const HOME_HEADER = "home_header";

     public static function getSliderGroups()
     {
         return [
            SliderGroups::HOME_HEADER => 'home_header'            
         ];
     }

     public static function getSliderGroupsValues()
     {
         return array_keys(self::getSliderGroups());
     }

     public static function getSliderGroup($key = '')
     {
         return !array_key_exists($key, self::getSliderGroup()) ?
          " " : self::getSliderGroup()[$key];
     }
 }

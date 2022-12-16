<?php

use App\Http\Controllers\HomeController;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\LazyCollection;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[HomeController::class, 'index']);

Route::get('/test', function(){
    function beautifulDays($i, $j, $k, $counter = 0) {
        for($x = $i; $x <= $j; $x++){
            if(abs(intval(implode(array_reverse(str_split($x)))) - $x) % $k == 0){
                $counter++;
            }
        }
        return $counter;
    }
    echo beautifulDays(20, 23, 6)."<br>";
    echo beautifulDays(13, 45, 3)."<br>";
    echo beautifulDays(1, 2000000, 23047885)."<br>";
});

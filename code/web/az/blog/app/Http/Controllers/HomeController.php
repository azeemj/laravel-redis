<?php

namespace App\Http\Controllers;

use App;
use Intervention\Image\Facades\Image;
use FunctionsLib;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redis;
require 'app/lib/myfunctions.php';

use App\myLib_app\myfunctions;

class HomeController extends Controller {

    function index() {

        print_r(Input::get());

        $token = myfunctions::getAuthToken(Input::get());
        $data = Input::get();
               
        myfunctions::storeToCache($data,$token);

        
    }
    
    function storeToDB(){
        $count=myfunctions::getAllCachedTokens("T~*");
        echo "stored to Db count".$count;
        
    }
    
    function deleteCache(){
        $count=myfunctions:: deletAllCachedTokens("T~*");
         echo json_encode($count);
    }
    
    function totalCache(){
        $count=myfunctions:: unstoredAllCachedTokens("T~*");
        echo json_encode($count);
    }
    

    
}

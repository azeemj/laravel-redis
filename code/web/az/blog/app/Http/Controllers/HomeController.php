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

    /**
     * stroing into cache
     */
    function index() {



        $token = myfunctions::getAuthToken(Input::get());
        $data = Input::get();

        myfunctions::storeToCache($data, $token);
        echo "stored to cache";
    }

    /**
     * stroring into DB
     */
    function storeToDB() {
        $count = myfunctions::getAllCachedTokens("T~*");
        echo "stored to Db count" . $count . "\n";
    }

    /**
     * delete un processed cached
     */
    function deleteCache() {
        $count = myfunctions:: deletAllCachedTokens("T~*");
        echo json_encode($count);
    }

    /**
     * Total un processed cached data
     */
    function totalCache() {
        $count = myfunctions:: unstoredAllCachedTokens("T~*");
        echo json_encode($count);
        echo ' --total unprocessed\n';
    }

    /**
     * getting statics
     */
    function stats() {
        $result = myfunctions:: stats();
        echo "" . $result[0];
        echo "" . $result[1];
    }

}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Intervention\Image\Facades\Image;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redis;
require '../app/lib/myfunctions.php';
require './TestCase.php';
class TokenTest extends TestCase {

    public function setUp() {
        parent::setUp();

        Session::start();

        // Enable filters
        Route::enableFilters();
    }

    /**
     * getting all payment methods which are actively available
     */
    public function teststoreToCache() {

$data=array ( "msisdn" => "60123456789", "operatorid" => "3" ,"shortcodeid" => "8", "text" => "ON GAMES" ) ;
$token = $token . "" . time();
        $all_data = myfunctions::storeToCache($data, $token);

        if (count($all_data) > 0) {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }
    }

    


    

}

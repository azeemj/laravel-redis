<?php
namespace App\myLib_app;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Illuminate\Support\Facades\DB;
use App\Mo;
use Illuminate\Support\Facades\Redis;
Class myfunctions {

    private $key = '';

    public function __construct() {
        
    }
    
/**
 * 
 * @param type $req
 * @return type
 */   
static function getAuthToken($req) {
    $arg = json_encode($req);
    return `./registermo $arg`;
}

/**
 * @param data
 * @param type $token
 * @return $id
 */
static function saveTokentoDB($data,$token) {
   
         $obj= new Mo();
        $obj->msisdn=$data['msisdn'];
        $obj->operatorid=$data['operatorid'];
        $obj->shortcodeid=$data['shortcodeid'];
        $obj->text  =$data['text'];
        $obj->auth_token=$token;
        $obj->save();
        return $obj->id;    
            
}
/**
 * 
 * @param type $data
 * @param string $token
 * @return none
 */
static function storeToCache($data,$token) {
       
        $token = $token . "" . time();
        $redis = Redis::connection();
        $value=array("token"=>$token,"data"=>$data,"db_updated"=>0);  
        echo $key="T~".$token; 
        $redis->set($key, json_encode($value));
        $name = $redis->get($key);
;
    }

    /*
     * save the all cached tokens
     * @param $key_name
     * @return count
     */
  static  public function getAllCachedTokens($key_name)
{
    $redis =Redis::connection();
    $keys = $redis->keys($key_name);
    $count = 0;
    foreach ($keys as $key) {
       // $redis->del($key);
        $data = $redis->get($key);
        $arr_data=(json_decode($data, true));
        $data=$arr_data['data'];
        $token=$arr_data['token'];
        myfunctions::saveTokentoDB($data,$token);
        $redis->del($key);
        $count++;
    }  
    echo $count;
    return $count;  
}

/**
 * delete unstored db data that are existing in cache
 * @param type $key_name
 * @return int
 */
 static  public function deletAllCachedTokens($key_name)
{
    $redis =Redis::connection();
    $keys = $redis->keys($key_name);
    $count = 0;
    foreach ($keys as $key) {
       // $redis->del($key);
        $data = $redis->get($key);
        $redis->del($key);
        $count++;
    }  
   
    return $count;  
}

 static  public function unstoredAllCachedTokens($key_name)
{
    $redis =Redis::connection();
    $keys = $redis->keys($key_name);
    return sizeof($keys);
}

}
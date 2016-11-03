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
use Carbon\Carbon;

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
    static function saveTokentoDB($data, $token, $time) {

        $obj = new Mo();

        $obj->msisdn = $data['msisdn'];
        $obj->operatorid = $data['operatorid'];
        $obj->shortcodeid = $data['shortcodeid'];
        $obj->text = $data['text'];
        $obj->auth_token = $token;
        $obj->created_at = $time;
        ;
        ;
        $obj->save();
        return $obj->id;
    }

    /**
     * 
     * @param type $data
     * @param string $token
     * @return none
     */
    static function storeToCache($data, $token) {
        //print_r($data);
        $token = $token;
        $redis = Redis::connection();
        $date = date("Y-m-d H:i:s");

        $value = array("token" => $token, "data" => $data, "time" => $date);
        $key = "T~" . $token;
        $redis->set($key, json_encode($value));
        $name = $redis->get($key);
    }

    /*
     * save the all cached tokens
     * @param $key_name
     * @return count
     */

    static public function getAllCachedTokens($key_name) {
        $redis = Redis::connection();
        $keys = $redis->keys($key_name);
        $count = 0;
        foreach ($keys as $key) {
            // $redis->del($key);
            $data = $redis->get($key);
            $arr_data = (json_decode($data, true));
            //print_r($arr_data);
            $data = $arr_data['data'];
            $time = $arr_data['time'];
            $token = $arr_data['token'];
            myfunctions::saveTokentoDB($data, $token, $time);
            $redis->del($key);
            $count++;
        }

        return $count;
    }

    /**
     * delete unstored db data that are existing in cache
     * @param type $key_name
     * @return int
     */
    static public function deletAllCachedTokens($key_name) {
        $redis = Redis::connection();
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
    /**
     * 
     * @param type $key_name
     * @return int
     */
    static public function unstoredAllCachedTokens($key_name) {
        $redis = Redis::connection();
        $keys = $redis->keys($key_name);
        return sizeof($keys);
    }

    /**
     * @param none
     * @return array
     */
    static function stats() {
        $response = array();
        $t15m_ago = new \DateTime("15 minutes ago");
        $s = $t15m_ago->format("Y-m-d H:i:s");
        $result = DB::table('mo_azeem')->where('created_at', '>', $s)->count();
        $one="15 minutes ago count" . $result . "\n";
        $response[0]=$one;
        $result4 = Mo::orderBy('id', 'DESC')->take(10000)->select(DB::raw("MAX(created_at) AS max_created_at"), \DB::raw("MIN(created_at) AS min_created_at")
                )->get()->toArray();

        $two="<br>time_span_last_10k" . json_encode($result4) . "\n";
        $response[1]=$two;
        return         $response ;

        
    }

}

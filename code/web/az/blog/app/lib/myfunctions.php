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
static function saveTokentoDB($data,$token,$time) {
   echo "cc".$time;
         $obj= new Mo();
         
        $obj->msisdn=$data['msisdn'];
        $obj->operatorid=$data['operatorid'];
        $obj->shortcodeid=$data['shortcodeid'];
        $obj->text  =$data['text'];
        $obj->auth_token=$token;
        $obj->created_at=  $time;;;
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
       echo  $date=  $date = date("Y-m-d H:i:s");

        $value=array("token"=>$token,"data"=>$data,'time'=>$date);  
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
        print_r($arr_data);
        $data=$arr_data['data'];
        $time=$arr_data['time'];
        $token=$arr_data['token'];
        myfunctions::saveTokentoDB($data,$token,$time);
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

static function stats(){

$response = array();

//$t15m_ago = new DateTime("15 minutes ago");
//$s = $t15m_ago->format("Y-m-d H:i:s");
//$result = mysql_query("SELECT count(*) from mo where created_at > '$s'");
//$response['last_15_min_mo_count'] = current(mysql_fetch_row($result));




  /*  

$result = mysql_query("SELECT min(created_at), max(created_at) from mo order by id DESC limit 10000");
$response['time_span_last_10k'] = mysql_fetch_row($result);

echo json_encode($response)."\n";

$date = new DateTime;
$date->modify('-5 minutes');
$formatted_date = $date->format('Y-m-d H:i:s');
*/
    
  //$date =  new DateTime();
//$date->modify('-5 minutes');
//$formatted_date = $date->format('Y-m-d H:i:s');

$t15m_ago = new \DateTime("15 minutes ago");
$s = $t15m_ago->format("Y-m-d H:i:s");
$result = DB::table('mo_azeem')->where('created_at','>',$s)->count();
echo "15 minutes ago count".$result."\n";

$result4 = Mo::orderBy('id', 'DESC')->take(10000)->select(DB::raw("MAX(created_at) AS max_created_at"),\DB::raw("MIN(created_at) AS min_created_at")
        )->get()->toArray();

echo "<br>time_span_last_10k". json_encode($result4)."\n";


//print_r($result_3);

}

}
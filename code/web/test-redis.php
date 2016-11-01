<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require "Predis.php";
$redis = new Predis_Client();
$redis->set('library', 'predis');
$value = $redis->get('library');
?>

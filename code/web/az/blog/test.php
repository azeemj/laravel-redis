<?php
use App\myLib_app\myfunctions;

echo "test";
require './app/lib/myfunctions.php';
 $count=  \App\Http\Controllers\HomeController::totalCache();
        echo $count;
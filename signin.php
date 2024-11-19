<?php

session_start();

require "vendor/autoload.php";

use myPHPnotes\Microsoft\Auth;


$tenant = "common";
$client_id = "992a7503-824e-4dfc-82ab-acd604bf547b";
$client_secret = "~6A8Q~qPtv0A7WWZnokgAtPc41uhDqlU6cFVebJW";
$callback = "http://localhost:443/callback.php";
$scopes = ["User.Read"];


$microsoft = new Auth($tenant, $client_id,  $client_secret, $callback, $scopes);
header("location: " . $microsoft->getAuthUrl());
<?php
$config = require 'config.php';
header('Access-Control-Allow-Origin: ' . $config['origin_host']);
require 'vendor/autoload.php';
//Get the refresh timeout for the given camera for use in JavaScript

if (in_array($_GET['camera'], $config) && in_array('limit', $config[$_GET['camera']]))
{
    echo $config[$_GET['camera']]['limit'] * 1000;
}
else
    echo $config['limit'] * 1000;

<?php
ini_set('display_errors', true);

use datagutten\webcam\CameraCache;

require 'vendor/autoload.php';

$config = require __DIR__ . '/config.php';
$config['cameras'] = require __DIR__ . '/cameras.php';
$key = $argv[1] ?? $_GET['camera'];

if (!isset($config['cameras'][$key]))
    die('Invalid camera');
else
    $camera = $config['cameras'][$key];

$cache = new CameraCache($camera, $key, $config['cache_path']);
$cache->limit = $config['limit'];

$image = $cache->fetch(); //Do not send headers if fetch fails
header('Content-type: ' . $camera->getMime());
header(sprintf('Cache-Control: max-age=%d', $cache->limit));
echo $image;

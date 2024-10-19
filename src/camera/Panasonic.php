<?php

namespace datagutten\webcam\camera;

class Panasonic extends Camera
{
    public static string $mime = 'image/jpeg';
    public static string $extension = 'jpg';

    public function fetch(): string
    {
        $url = sprintf('http://%s/SnapshotJPEG?Resolution=640x480&Quality=Standard&View=Normal', $this->ip);
        return $this->get($url);
    }
}
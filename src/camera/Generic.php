<?php

namespace datagutten\webcam\camera;

class Generic extends Camera
{
    public static string $mime = 'image/jpeg';
    public static string $extension = 'jpg';
    public string $url;

    public function __construct($ip, $username, $password, $url)
    {
        $this->url = $url;
        parent::__construct($ip, $username, $password);
    }

    /**
     * @inheritDoc
     */
    public function fetch(): string
    {
        return $this->get($this->url);
    }
}
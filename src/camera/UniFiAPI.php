<?php

namespace datagutten\webcam\camera;

use WpOrg\Requests;

class UniFiAPI extends Camera
{
    public static string $mime = 'image/jpeg';
    public static string $extension = 'jpg';
    public string $camera_id;

    /** @noinspection PhpMissingParentConstructorInspection */
    public function __construct($ip, $api_key, $camera_id)
    {
        $this->ip = $ip;
        $this->camera_id = $camera_id;
        $this->session = new Requests\Session(headers: ['Accept' => 'application/json', 'X-API-Key' => $api_key]);
        $this->session->options['verify'] = false;
    }

    public function fetch(): string
    {
        $url = sprintf("https://%s/proxy/protect/integration/v1/cameras/%s/snapshot", $this->ip, $this->camera_id);
        return $this->get($url);
    }
}
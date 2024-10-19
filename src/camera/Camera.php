<?php

namespace datagutten\webcam\camera;

use datagutten\webcam\exceptions;
use datagutten\webcam\exceptions\CameraException;
use WpOrg\Requests;

abstract class Camera
{
    public string $ip;
    protected Requests\Session $session;
    public static string $mime;
    public static string $extension;

    public function __construct($ip, $username, $password)
    {
        $this->ip = $ip;
        $this->session = new Requests\Session('http://' . $this->ip, [], [], ['auth' => new Requests\Auth\Basic([$username, $password])]);
    }

    /**
     * @param string $url Image URL
     * @param array $headers
     * @param array $options Requests options
     * @return string
     * @throws CameraException
     */
    public function get(string $url, array $headers = [], array $options = []): string
    {
        $response = $this->session->get($url, $headers, $options);
        if (!$response->success)
            throw new exceptions\CameraException(sprintf('Request failed, status code %d', $response->status_code));
        return $response->body;
    }

    public function getExtension(): string
    {
        return static::$extension;
    }

    public function getMime(): string
    {
        return static::$mime;
    }

    /**
     * Fetch an image from the camera and return the image as bytes
     * @return string
     * @throws  exceptions\CameraException
     */
    abstract public function fetch(): string;
}
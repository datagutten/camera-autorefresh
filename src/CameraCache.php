<?php

namespace datagutten\webcam;

use datagutten\tools\files\files;
use Symfony\Component\Filesystem\Filesystem;

class CameraCache
{
    public camera\Camera $camera;
    public string $key;
    /**
     * @var int Limit in seconds before new image can be fetched
     */
    public int $limit = 60;
    /**
     * @var string Image folder
     */
    public string $folder;
    public bool $timestamp_file = false;
    public Filesystem $filesystem;

    public function __construct(camera\Camera $camera, $key, $cache_path = null)
    {
        $this->filesystem = new Filesystem();
        $this->camera = $camera;
        $this->key = $key;
        if (empty($cache_path))
            $this->folder = files::path_join(__DIR__, 'images', $key);
        else
            $this->folder = files::path_join(realpath($cache_path), 'images', $key);

        if (!file_exists($this->folder))
            $this->filesystem->mkdir($this->folder);
    }

    public function last_file()
    {
        $files = files::get_files($this->folder, [$this->camera->getExtension()]);
        return array_pop($files);
    }

    public function file(): string
    {
        return files::path_join($this->folder, $this->key . '.' . $this->camera->getExtension());
    }

    public function fetch(): string
    {
        $time = time();
        if ($this->timestamp_file)
            $cache_file = $this->last_file();
        else
            $cache_file = $this->file();

        //$image_time = basename($last_file, '.' . $this->camera->getExtension());

        if ($this->filesystem->exists($cache_file))
        {
            $image_time = filemtime($cache_file);
            $diff = $time - $image_time;
            if ($diff < $this->limit)
                return file_get_contents($cache_file);
        }

        $bytes = $this->camera->fetch();
        if ($this->timestamp_file)
            $cache_file = files::path_join($this->folder, $time . '.' . $this->camera->getExtension());
        $this->filesystem->dumpFile($cache_file, $bytes);
        return $bytes;
    }
}
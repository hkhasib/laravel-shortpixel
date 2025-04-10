<?php

namespace Hkhasib\LaravelShortPixel;

use ShortPixel;

class LaravelShortPixel
{

    protected $file;

    protected $customizeableConfigs = [
        'convertto',
        'keep_exif'
    ];

    public function __construct()
    {
        ShortPixel\setKey(config('shortpixel.api_key'));

        foreach ($this->customizeableConfigs as $config) {
            if ($value = config('shortpixel.' . $config)) {
                ShortPixel\ShortPixel::setOptions(array($config => $value));
            }
        }
    }

    public function refreshFromUrls($url, $path = null, $filename = null, $level = null,
                                    $webp=true,$avif=false,
                                    $width = null, $height = null, $max = false, $refresh=true)
    {
        return $this->fromUrls($url, $path, $filename, $level, $webp, $avif, $width, $height, $max, $refresh);
    }

    public function refreshFromFiles($url, $path = null, $level = null, $webp=true,$avif=false,
                                     $width = null, $height = null, $max = false, $refresh=true)
    {
        return $this->fromFiles($url, $path, $level, $webp, $avif, $width, $height, $max, $refresh);
    }

    public function refreshFromFolder($folder, $path = null, $level = null, $webp=true,$avif=false,
                                      $width = null, $height = null, $max = false, $refresh=true)
    {
        return $this->fromFolder($folder, $path, $level, $webp, $avif, $width, $height, $max, $refresh);
    }
    public function fromUrls($url, $path = null, $filename = null, $level = null, $webp=true, $avif=false, $width = null, $height = null, $max = false, $refresh=false)
    {
        if (!$path) {
            $path = config('shortpixel.default_path');
        }

        $this->file = ShortPixel\fromUrls($url);
        return $this->save($path, $filename, $level, $webp, $avif, $width, $height, $max, $refresh);
    }

    public function fromFiles($url, $path = null, $level = null, $webp=true, $avif=false, $width = null, $height = null, $max = false, $refresh=false)
    {
        if (!$path) {
            $path = config('shortpixel.default_path');
        }

        if (is_array($url)) {
            $this->file = ShortPixel\fromFiles($url);
        } else {
            $this->file = ShortPixel\fromFiles($url);
        }

        return $this->save($path, null, $level, $webp, $avif, $width, $height, $max, $refresh);
    }

    public function fromFolder($folder, $path = null, $level = null, $webp=true, $avif=false, $width = null, $height = null, $max = false, $refresh=false)
    {
        \ShortPixel\ShortPixel::setOptions(array("persist_type" => "text"));

        if (!$path) {
            $path = config('shortpixel.default_path');
        }

        $this->file = ShortPixel\fromFolder($folder)->wait(300);
        return $this->save($path, null, $level, $webp, $avif, $width, $height, $max, $refresh);
    }

    private function optimize($level = null)
    {
        if (!$level) {
            $level = config('shortpixel.compression_level');
        }

        return $this->file->optimize($level);
    }

    private function resize($width, $height, $max = false)
    {
        return $this->file->resize($width, $height, $max);
    }

    private function refresh(){
        return $this->file->refresh();
    }

    private function generateWebp(){
        return $this->file->generateWebP();
    }

    private function generateAVIF()
    {
        return $this->file->generateAVIF();
    }

    private function save($path, $filename = null, $level = null, $webp=true, $avif=false,
                          $width = null, $height = null, $max = false, $refresh=false)
    {
        $this->optimize($level);

        if ($width && $height) {
            $this->resize($width, $height, $max);
        }

        $webp && $this->generateWebp();

        $avif && $this->generateAVIF();

        $refresh && $this->refresh();

        return $this->file->toFiles($path, $filename);
        
    }
}

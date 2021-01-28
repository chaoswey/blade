<?php namespace App\Builders;

use Intervention\Image\ImageManager;

class Image
{
    protected static $instance;

    protected $target = '';

    public function __construct(string $path = null, string $format = null, ?int $width = null, ?int $height = null)
    {
        if (empty(static::$instance)) {
            $setting = !extension_loaded('imagick') ? ['driver' => 'gd'] : ['driver' => 'imagick'];
            static::$instance = new ImageManager($setting);
        }

        if ($this->exists($path) && !$this->exists($this->target = $this->target($path, $format, $width, $height))) {
            $this->make($path, $this->target, $width, $height);
        }
    }

    protected function target(string $path = null, string $format = null, ?int $width = null, ?int $height = null): string
    {
        $size = '';
        if ($width !== null && $height === null) {
            $size = $width.'xauto';
        }

        if ($width === null && $height !== null) {
            $size = 'autox'.$height;
        }

        if ($width !== null && $height !== null) {
            $size = $width.'x'.$height;
        }

        $info = pathinfo($path);
        $format = $format ? strtolower($format) : $info['extension'];
        $filename = !empty($size) ? $info['filename']."_".$size : $info['filename'];

        return $info['dirname'].'/'.$filename.'.'.$format;
    }

    protected function exists(?string $path = null): bool
    {
        return !empty($path) && file_exists(Path::public_path($path)) && is_file(Path::public_path($path));
    }

    protected function make(string $path, string $target, ?int $width = null, ?int $height = null): void
    {
        $image = self::$instance->make(Path::public_path($path));

        if ($width === null && $height !== null) {
            $image->resize(null, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        if ($width !== null && $height === null) {
            $image->resize($width, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        if ($width !== null && $height !== null) {
            $image->fit($width, $height);
        }

        $image->save(Path::public_path($target), 90);
    }

    public function __toString(): ?string
    {
        return $this->target;
    }
}
<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class FileService
{
    public function upload(
        ?UploadedFile $file,
        string        $directory,
        string        $disk = 'public',
        string        $default = 'noimage.jpg'
    ): string
    {
        if (!$file) {
            return $default;
        }

        return $file->store($directory, $disk);
    }
}

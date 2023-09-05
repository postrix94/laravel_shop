<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FileStorageService implements Interfaces\IFileStorageService
{

    public static function upload(string|UploadedFile $file, string $additionalPath = ""): string
    {
        if(!empty($additionalPath)) {
            $additionalPath .= "/";
        }

        $filePath = "public/{$additionalPath}" . Str::random() . "_" . time() . "." . $file->getClientOriginalExtension();
        \Storage::disk('s3')->put($filePath, File::get($file));

        return $filePath;
    }

    public static function remove(string $file): void
    {
        \Storage::disk('s3')->delete($file);
    }
}

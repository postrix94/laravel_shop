<?php


namespace App\Services\Interfaces;


use Illuminate\Http\UploadedFile;

interface IFileStorageService
{
    public static function upload(UploadedFile | string $file, string $additionalPath = ""): string;

    public static function remove( string $file): void;
}

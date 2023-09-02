<?php

namespace Tests\Unit\Services;

use App\Services\FileStorageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;


class FileStorageServiceTest extends TestCase
{
    public function test_upload_file() {
        $filePath = $this->uploadFile();
        $this->assertTrue(Storage::has($filePath));
    }

    public function test_upload_file_with_path() {
        $filePath = $this->uploadFile('test/path');
        $this->assertStringContainsString('test/path', $filePath);
        $this->assertTrue(Storage::has($filePath));
    }

    public function test_remove_file() {
        $filePath = $this->uploadFile();
        $this->assertTrue(Storage::has($filePath));

        FileStorageService::remove($filePath);

        $this->assertFalse(Storage::has($filePath));

    }

    protected function uploadFile($additionalPath = '', $fileName = 'image.png') {
        $file = UploadedFile::fake()->create($fileName);
        return FileStorageService::upload($file, $additionalPath);
    }

}

<?php

namespace App\Service;

class ImageUploader
{
    public function __construct(
        protected string $uploadDir
    )
    {
    }

    public function uploadFromPath(string $sourcePath): string
    {
        if (!file_exists($sourcePath)) {
            throw new \RuntimeException("Source image not found: " . $sourcePath);
        }

        $filename = uniqid() . '.' . pathinfo($sourcePath, PATHINFO_EXTENSION);

        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }

        copy($sourcePath, $this->uploadDir . '/' . $filename);

        return $filename;
    }
}
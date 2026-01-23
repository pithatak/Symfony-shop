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

    public function downloadImage($imageUrl)
    {
        // Получить содержимое изображения
        $imageContent = file_get_contents($imageUrl);

        if ($imageContent === false) {
            throw new \Exception("Не удалось скачать изображение по URL: $imageUrl");
        }

        // Если имя файла не указано, используем имя из URL
//        if (!$fileName) {
//            $fileName = basename($imageUrl); // Извлекает имя файла из URL
//        }

        $slug = strtolower($imageUrl);

        $slug = preg_replace('/[\s_]+/', '-', $slug);

        $slug = preg_replace('/[^a-z0-9-]/', '', $slug);

        $safeFilename = trim($slug, '-');

        $newFilename = $safeFilename . '-' . uniqid() . '.jpg';

        // Полный путь для сохранения изображения
        $fullPath = $this->uploadDir . DIRECTORY_SEPARATOR . $newFilename;

        // Сохранение изображения на сервере
        $result = file_put_contents($fullPath, $imageContent);

        if ($result === false) {
            throw new \Exception("Не удалось сохранить изображение: $fullPath");
        }

        return $newFilename; // Возвращает полный путь к сохраненному файлу
    }
}
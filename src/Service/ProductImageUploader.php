<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\Attribute\Autowire;

class ProductImageUploader extends ImageUploader
{
    public function __construct(
        #[Autowire('%brochures_directory%')]
        string $uploadDir
    ) {
        parent::__construct($uploadDir);
    }
}
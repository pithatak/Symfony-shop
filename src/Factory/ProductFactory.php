<?php

namespace App\Factory;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use App\Service\ProductImageUploader;

class ProductFactory
{
    public function __construct(public ProductImageUploader $PIUploader)
    {}
    public function create(string $name, float $price, Category $category, User $user, string $imagePath): Product
    {
        $product = new Product();
        $product->setName($name);
        $product->setPrice($price);
        $product->setUser($user);
        $product->setCategory($category);
        $image = $this->PIUploader->uploadFromPath($imagePath);
        $product->setBrochureFilename($image);

        return  $product;
    }
}
<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;

class ProductService
{
    public function __construct(
        private ProductRepository    $productRepository,
        private UserRepository       $userRepository,
        private ProductImageUploader $PIUploader)
    {
    }

    public function saveScrapedProducts(array $products)
    {
        foreach ($products as $productData) {
            $product = new Product();
            $product->setName($productData['name']);

            if ($productData['price']) {
                $price = str_replace(' ', '', $productData['price']);
                preg_match('/[\d,]+/', $price, $matches);
                $product->setPrice($matches[0]);
            } else {
                $product->setPrice(0);
            }

            if ($productData['discount']) {
                $discount = str_replace(' ', '', $productData['discount']);
                preg_match('/[\d,]+/', $discount, $matches);
                $product->setDiscount($matches[0]);
            }

            $bruchureName = $this->PIUploader->downloadImage($productData['image_url']);
            $product->setBrochureFilename($bruchureName);
            $product->setUser($this->userRepository->getUser());

            $this->productRepository->save($product, true);
        }
    }
}
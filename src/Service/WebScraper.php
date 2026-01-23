<?php

namespace App\Service;

use Goutte\Client;

class WebScraper
{
    private $client;
    private $crawler;
    public function __construct()
    {
        $this->client = new Client();
    }


    private function crawlerFilter(array $htmlElements): array
    {
        $products = [];

        $this->crawler->filter($htmlElements['mainBlock'])->each(function ($node) use ($htmlElements, &$products) {
            if ($node->filter($htmlElements['nameTag'])->count()){
                $name = $node->filter($htmlElements['nameTag'])->text();
                $price = $node->filter($htmlElements['priceTag'])->count() ? $node->filter($htmlElements['priceTag'])->text() : 0;
                $imageUrl = $node->filter($htmlElements['imgTag'])->attr('src');
                $discount = $node->filter($htmlElements['discountTag'])->count() ? $node->filter($htmlElements['discountTag'])->text() : NULL;
                $products[] = [
                    'name' => $name,
                    'price' => $price,
                    'image_url' => $imageUrl,
                    'discount' => $discount,
                ];
            }
        });

        return $products;
    }

    public function scrapeDashumiaocoinProducts(): array
    {
        $url = 'https://www.dashumiaocoin.com/Products/list-r1.html';

        $this->crawler = $this->client->request('GET', $url);

        $htmlElements = [
            'mainBlock' => 'ul.common_pro_list1 li',
            'nameTag' => 'a.name',
            'priceTag' => 'div.price',
            'imgTag' => 'a img',
            'discountTag' => ''
        ];

        return $this->crawlerFilter($htmlElements);
    }

    public function scrapeAmazonProducts(): array
    {
        $url = 'https://www.amazon.pl/gp/bestsellers?ref_=nav_cs_bestsellers';

        $this->crawler = $this->client->request('GET', $url);

        $htmlElements = [
            'mainBlock' => 'ol.a-carousel li',
            'nameTag' => 'div.p13n-sc-truncate-desktop-type2',
            'priceTag' => 'span._cDEzb_p13n-sc-price_3mJ9Z',
            'imgTag' => 'div.a-spacing-mini img',
            'discountTag' => ''
        ];

        return $this->crawlerFilter($htmlElements);
    }

    public function scrapePromProducts(): array
    {
        $url = 'https://prom.ua/sc/military';

        $this->crawler = $this->client->request('GET', $url);

        $htmlElements = [
            'mainBlock' => 'div.JicYY',
            'nameTag' => 'picture img',
            'priceTag' => '.AJ5TG [data-qaid="old_price"]',
            'imgTag' => 'picture img',
            'discountTag' => '.AJ5TG [data-qaid="product_price"]'
        ];


        return $this->crawlerFilter($htmlElements);
    }
}
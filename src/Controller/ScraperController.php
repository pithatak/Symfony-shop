<?php

namespace App\Controller;

use App\Service\ProductService;
use App\Service\WebScraper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ScraperController extends AbstractController
{
    private $scraper;

    public function __construct(WebScraper $scraper)
    {
        $this->scraper = $scraper;
    }

    /**
     * @Route("/scrape/Dashumiaocoin", name="scrapeDashumiaocoin")
     */
    public function scrapeDashumiaocoin(ProductService $productService): Response
    {
        $data = $this->scraper->scrapeDashumiaocoinProducts();
        $productService->saveScrapedProducts($data);

        return $this->redirectToRoute('sonata_admin_dashboard');
    }

    /**
     * @Route("/scrape/Amazon", name="scrapeAmazon")
     */
    public function scrapeAmazon(ProductService $productService): Response
    {

        $data = $this->scraper->scrapeAmazonProducts();
        $productService->saveScrapedProducts($data);

        return $this->redirectToRoute('sonata_admin_dashboard');
    }

    /**
     * @Route("/scrape/Prom", name="/scrape/Prom")
     */
    public function scrapeProm(ProductService $productService): Response
    {
        $data = $this->scraper->scrapePromProducts();
        $productService->saveScrapedProducts($data);

        return $this->redirectToRoute('sonata_admin_dashboard');
    }
}

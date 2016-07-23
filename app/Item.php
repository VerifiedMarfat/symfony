<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Symfony\Component\DomCrawler\Crawler;

class Item extends Model
{
    /**
     * The endpoint of the landing page.
     *
     * @var string
     */
    private static $homepage = 'http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/5_products.html';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'size', 'unit_price', 'description'
    ];

    /**
     * Reads the html page.
     * @return object
     */
    private static function connect($url = false)
    {
        if (!$url) {
            $url = self::$homepage;
        }

        $body = file_get_contents($url);
        $crawler = new Crawler($body);

        return $crawler;
    }

    /**
     * Extracts the titles of the products
     * @return array
     */
    public static function getTitles()
    {
        $crawler = self::connect();
        $titles = $crawler->filter('h3 > a')->each(function (Crawler $node, $i) {
            return trim($node->text());
        });

        return $titles;
    }

    /**
     * Extracts the links of the products
     * @return array
     */
    public static function getLinks()
    {
        $crawler = self::connect();
        $links = $crawler->filter('h3 > a')->each(function (Crawler $node, $i) {
            return $node->attr('href');
        });

        return $links;
    }

    /**
     * Extracts the price of each product
     * @return array
     */
    public static function getPrices()
    {
        $crawler = self::connect();
        $prices = $crawler->filter('p.pricePerMeasure')->each(function (Crawler $node, $i) {
            $price = str_replace('&pound', '', $node->text());
            $price = str_replace('/ea', '', $price);

            return (float) $price;
        });

        return $prices;
    }

    /**
     * Extracts the description of each product
     * @return array
     */
    public static function getDescriptions()
    {
        $links = self::getLinks();
        $copy = [];

        foreach ($links as $link) {
            $crawler = self::connect($link);
            $content = $crawler->filter('#information .productText')->first()->text();
            $copy[] = trim($content);
        }

        return $copy;
    }

    /**
     * Extracts the page details page and retrieves its size in KB
     * @return array
     */
    public static function getSizes()
    {
        $links = self::getLinks();
        $sizes = [];

        foreach ($links as $link) {
            $headers = get_headers($link, 1);
            $bytes = $headers['Content-Length'];
            $sizes[] = $size = round($bytes / 1024, 2) .'kb';
        }

        return $sizes;
    }

    /**
     * Constructs the items based on the extracted data
     * @return array
     */
    public static function getItems()
    {
        $results = [];
        foreach (self::getTitles() as $item) {
            $results[]['title'] = $item;
        }

        $i = 0;
        foreach (self::getSizes() as $item) {
            $results[$i]['size'] = $item;
            $i++;
        }

        $i = 0;
        foreach (self::getPrices() as $item) {
            $results[$i]['unit_price'] = $item;
            $i++;
        }

        $i = 0;
        foreach (self::getDescriptions() as $item) {
            $results[$i]['description'] = $item;
            $i++;
        }

        return $results;
    }

    /**
     * Calculates the total price baed on unit prices of all items
     * @return array
     */
    public static function getTotal()
    {
        $total = 0;
        foreach (self::getPrices() as $item) {
            $total += $item;
        }

        return round($total, 2);
    }

    /**
     * Creates the finalised items array.
     * @return array
     */
    public static function get()
    {
        $items = self::getItems();
        $items['total'] = self::getTotal();

        return $items;
    }
}

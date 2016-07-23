<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Symfony\Component\DomCrawler\Crawler;

class Item extends Model
{

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
    private static function connect()
    {
        $homepage = 'http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/5_products.html';
        $body = file_get_contents($homepage);
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
            return $node->text();
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
}

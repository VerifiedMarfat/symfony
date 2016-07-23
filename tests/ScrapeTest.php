<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

use App\Guzzle;
use App\Item;

class ScrapeTest extends TestCase
{
    /**
     * A basic test to connect to main endpoint.
     *
     * @return void
     */
    public function testTitles()
    {
        $titles = Item::getTitles();
        $this->assertGreaterThan(0, count($titles));
    }

     /**
     * A test to get the links to each product
     *
     * @return void
     */
    public function testURLs()
    {
        $links = Item::getLinks();
        $this->assertGreaterThan(0, count($links));
    }
}

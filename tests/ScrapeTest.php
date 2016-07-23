<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

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

    /**
     * A test to get the price of each product
     *
     * @return void
     */
    public function testPrices()
    {
        $prices = Item::getPrices();
        $this->assertGreaterThan(0, count($prices));
    }

    /**
     * A test to get the size of each product
     *
     * @return void
     */
    public function testDescriptions()
    {
        $descriptions = Item::getDescriptions();
        $this->assertContains('Apricots', $descriptions);
        $this->assertContains('Avocados', $descriptions);
        $this->assertContains('Conference', $descriptions);
        $this->assertContains('Kiwi', $descriptions);
    }
}

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
        $this->assertContains('Sainsbury\'s Apricot Ripe & Ready x5', $titles);
        $this->assertContains('Sainsbury\'s Avocado Ripe & Ready XL Loose 300g', $titles);
        $this->assertContains('Sainsbury\'s Avocado, Ripe & Ready x2', $titles);
        $this->assertContains('Sainsbury\'s Avocados, Ripe & Ready x4', $titles);
        $this->assertContains('Sainsbury\'s Conference Pears, Ripe & Ready x4 (minimum)', $titles);
        $this->assertContains('Sainsbury\'s Golden Kiwi x4', $titles);
        $this->assertContains('Sainsbury\'s Kiwi Fruit, Ripe & Ready x4', $titles);
    }

     /**
     * A test to get the links to each product
     *
     * @return void
     */
    public function testURLs()
    {
        $links = Item::getLinks();
        $this->assertContains('http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/sainsburys-apricot-ripe---ready-320g.html', $links);
        $this->assertContains('http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/sainsburys-avocado-xl-pinkerton-loose-300g.html', $links);
        $this->assertContains('http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/sainsburys-avocado--ripe---ready-x2.html', $links);
        $this->assertContains('http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/sainsburys-avocados--ripe---ready-x4.html', $links);
        $this->assertContains('http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/sainsburys-conference-pears--ripe---ready-x4-%28minimum%29.html', $links);
        $this->assertContains('http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/sainsburys-golden-kiwi--taste-the-difference-x4-685641-p-44.html', $links);
        $this->assertContains('http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/sainsburys-kiwi-fruit--ripe---ready-x4.html', $links);
    }

    /**
     * A test to get the price of each product
     *
     * @return void
     */
    public function testPrices()
    {
        $prices = Item::getPrices();
        $this->assertContains(0.70, $prices);
        $this->assertContains(1.50, $prices);
        $this->assertContains(3.20, $prices);
        $this->assertContains(1.50, $prices);
        $this->assertContains(0.45, $prices);
        $this->assertContains(0.45, $prices);
    }

    /**
     * A test to get the description of each product
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

    /**
     * A test to get the size of each product page
     *
     * @return void
     */
    public function testSize()
    {
        $sizes = Item::getSizes();
        $this->assertContains('38.27kb', $sizes);
        $this->assertContains('38.67kb', $sizes);
        $this->assertContains('43.44kb', $sizes);
        $this->assertContains('38.68kb', $sizes);
        $this->assertContains('38.54kb', $sizes);
        $this->assertContains('38.56kb', $sizes);
        $this->assertContains('38.98kb', $sizes);
    }

    /**
     * A test to get the all the items
     *
     * @return void
     */
    public function testItems()
    {
        $items = Item::getItems();
        $this->assertEquals(7, count($items));
    }

    /**
     * A test to get the total amount
     *
     * @return void
     */
    public function testTotal()
    {
        $total = Item::getTotal();
        $this->assertEquals(9.60, $total);
    }

    /**
     * A test to get the completed item array
     *
     * @return void
     */
    public function testRequest()
    {
        $items = Item::get();
        // TODO :: write more detailed tests to check whether the data returned is correct.
        $this->assertEquals(8, count($items));
    }

}

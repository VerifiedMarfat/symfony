<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

use App\Guzzle;

class ScrapeTest extends TestCase
{
    /**
     * A basic test to connect to main endpoint.
     *
     * @return void
     */
    public function testScraping()
    {
        $endpoint = 'http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/5_products.html';
        $client = Guzzle::connect($endpoint);
        $this->assertObjectHasAttribute('config', $client);
    }
}

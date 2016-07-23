<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use GuzzleHttp\Client;

class Guzzle extends Model
{
    /**
     * Connects to the client
     * @return object
     */
    public static function connect($url)
    {
        return new Client([
            'base_uri' => $url,
            'timeout'  => 2.0,
        ]);
    }
}

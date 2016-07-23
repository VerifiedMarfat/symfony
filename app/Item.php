<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    public static function getLink()
    {
        dd("TODO :: start with 'productInfo' class.");
    }
}

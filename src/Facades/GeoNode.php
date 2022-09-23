<?php

namespace TungTT\LaravelGeoNode\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \TungTT\LaravelGeoNode\LaravelGeoNode
 */
class GeoNode extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \TungTT\LaravelGeoNode\LaravelGeoNode::class;
    }
}

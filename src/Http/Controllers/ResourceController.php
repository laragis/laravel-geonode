<?php
namespace TungTT\LaravelGeoNode\Http\Controllers;


class ResourceController extends GeoNodeController
{
    public function index(){
        return $this->get('/api/v2/resources');
    }
}

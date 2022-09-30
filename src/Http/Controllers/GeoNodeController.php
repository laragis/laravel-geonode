<?php

namespace TungTT\LaravelGeoNode\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use TungTT\LaravelGeoNode\Facades\GeoNode;

class GeoNodeController extends Controller
{
    /**
     * The HTTP Client instance.
     *
     * @var \GuzzleHttp\Client
     */
    protected Client $httpClient;


    public function __construct()
    {
        $this->httpClient = new Client([
            'base_uri' => config('geonode.url'),
        ]);
    }

    protected function handleRequest($request, $options = [])
    {
        if ($token = GeoNode::getAccessToken()) {
            $request = $request->withHeader('Authorization', 'Bearer ' . $token);
        }

        return $this->httpClient->send($request, $options);
    }

    protected function createRequest(...$args)
    {
        return new Request(...$args);
    }

    protected function getQuery(){
        $parts = parse_url($_SERVER['REQUEST_URI']);

        if(!isset($parts['query'])) return [];

        return [
            'query' => collect(explode('&', $parts['query']))->map(function ($param){
                return (string)Str::of($param)->replaceMatches('/(filter\[)(.+)(\]=\w*)$/', function ($match) {
                    $middle = collect(explode('][', $match[2]))->filter(fn($v) => $v);
                    if($middle->count() == 1) {
                        $middle = $middle->merge(['in'])->implode('.');
                    } else {
                        $middle = $middle->implode('.');
                    }
                    $start = Str::of($match[1])->replaceLast('[', '{');
                    $end = Str::of($match[3])->replaceFirst(']', '}');
                    return $start.$middle.$end;
                });
            })->implode('&')
        ];
    }

    protected function get($route)
    {
        $request = $this->createRequest('GET', $route);

        $response = $this->handleRequest($request, [
            ...$this->getQuery()
        ]);

        return $this->deserialize($response);
    }

//    protected function post($route, $data)
//    {
//        $request = $this->createRequest('POST', $route, [], $this->serialize($data));
//
//        $response = $this->handleRequest($request);
//
//        return $this->deserialize($response);
//    }
//
//    protected function put($route, $data)
//    {
//        $request = $this->createRequest('PUT', $route, [], $this->serialize($data));
//
//        $response = $this->handleRequest($request);
//
//        return $this->deserialize($response);
//    }
//
//    protected function delete($route)
//    {
//        $request = $this->createRequest('DELETE', $route, []);
//
//        $response = $this->handleRequest($request);
//
//        return $this->deserialize($response);
//    }

    protected function deserialize($response)
    {
        return json_decode($response->getBody());
    }
}

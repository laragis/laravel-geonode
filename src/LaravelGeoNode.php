<?php

namespace TungTT\LaravelGeoNode;

use App\Models\ConnectedAccount;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class LaravelGeoNode
{
    public string|null $accessToken;
    public string $url;
    public string|null $userId;
    public string $baseUrl;
    protected $user;

    public function __construct()
    {
        $appUser = auth()->user();
        $this->user = $appUser?->currentConnectedAccount;

        $this->userId = optional($this->user)->provider_id;
        $this->accessToken = optional($this->user)->token;
        $this->baseUrl = config('geonode.url');
    }

    protected function getUserId($userId = null){
        return $userId ?? $this->userId;
    }

    public function getAccessToken($accessToken = null){
        return $accessToken ?? $this->accessToken;
    }

    public function user($accessToken = null){
        if($accessToken) return ConnectedAccount::firstWhere('token', $accessToken);

        return $this->user;
    }

    public function tokenExpired(){
        return Carbon::parse($this->user->expires_at) < Carbon::now();
    }

    public function getUrl(string $url = ''){
        return $this->baseUrl.$url;
    }

    public function createToken(array $formData = []){
        $url = '/o/token/';

        $response = Http::withBasicAuth(
            env('GEONODE_CLIENT_ID'),
            env('GEONODE_CLIENT_SECRET'),
        )->asForm()->post($this->getUrl($url), array_merge([
            'grant_type' => 'password'
        ], $formData));

        return $response->json();
    }

    public function tokenInfo($accessToken = null){
        $url = '/api/o/v4/tokeninfo';
        $response = Http::asForm()->post($this->getUrl($url), ['token' => $this->getAccessToken($accessToken)]);
        return $response->json();
    }

    public function resourcesByUser($userId = null){
        $url = '/api/v2/users/'.$this->getUserId($userId).'/resources';

        $response = Http::get($this->getUrl($url), [
            'access_token' => $this->getAccessToken()
        ]);
        return $response->collect()->values();
    }


    public function layerResourcesByUser($userId = null){
        return $this->resourcesByUser($userId)->where('resource_type', 'layer')->map(fn($item) => [
            ...$item
        ])->values();
    }

    public function permissionsByResource($userId = null, $accessToken = null){
        $url = '/api/v2/resources/'.$this->getUserId($userId).'/get_perms';

        $response = Http::get($this->getUrl($url, [
            'access_token' => $this->getAccessToken()
        ]));

        return $response->json();
    }
}

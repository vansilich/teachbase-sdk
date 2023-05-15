<?php

namespace Teachbase\Endpoint;

use GuzzleHttp\Psr7\Request;
use \Psr\Http\Client\ClientInterface;
use Teachbase\Exceptions\ApiError;

class Oauth{

    public function __construct(
        private string $base_endpoint,
        private ClientInterface $httpClient
    ){}

    /**
     * Действителен ли access token
     */
    public function isValidAccessToken(string $accessToken): bool
    {
        $endpointUrl = $this->base_endpoint . '/endpoint/v1/_ping?';
        $endpointUrl .= http_build_query([
            'access_token' => $accessToken,
        ]);

        $request = new Request('GET', $endpointUrl);
        $response = $this->httpClient->sendRequest($request);

        if ($response->getStatusCode() !== 200){
            return false;
        }

        return true;
    }

    /**
     * @throws ApiError
     */
    public function getNewAccessToken(string $publicApiKey, string $secretApiKey): string
    {
        $endpointUrl = $this->base_endpoint . '/oauth/token?';
        $endpointUrl .= http_build_query([
            'client_secret' => $secretApiKey,
            'client_id' => $publicApiKey,
            'grant_type' => 'client_credentials',
        ]);

        $request = new Request('POST', $endpointUrl);
 
        $response = $this->httpClient->sendRequest($request);
        $responseBody = json_decode($response->getBody()->getContents());
        
        if ($response->getStatusCode() !== 200){
            throw new ApiError($responseBody->error, $response->getStatusCode());
        }

        if (!property_exists($responseBody, 'access_token')){
            throw new \RuntimeException('Api Teachbase не прилслало `access_token`');
        }

        return $responseBody->access_token;
    }

}
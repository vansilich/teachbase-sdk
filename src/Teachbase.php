<?php

namespace Teachbase;

use Teachbase\Endpoint\Oauth;
use Teachbase\Endpoint\User;
use Teachbase\Endpoint\CourseSessions;
use GuzzleHttp\Client;
use \Psr\Http\Client\ClientInterface;
use RuntimeException;

class Teachbase{

    private string $base_endpoint = 'https://go.teachbase.ru';
    private string $accessToken;
    
    public function __construct(
        private string $publicApiKey,
        private string $secretApiKey,
        private ?ClientInterface $httpClient = null,
    ){}

    /**
     * @throws RuntimeException
     */
    public function init(): void
    {
        if ($this->httpClient === null){
            $this->httpClient = $this->getDefaultHttpClient();
        }

        $this->accessToken = $this->getValidAccessToken();
    }

    /**
     * @throws RuntimeException
     */
    public function getValidAccessToken(): string
    {
        $oauth = $this->oauth();

        $accessToken = $oauth->getNewAccessToken($this->publicApiKey, $this->secretApiKey);

        // Проверяем валидность access токена
        if(!$oauth->isValidAccessToken($accessToken)){
            throw new RuntimeException('Teachbase API выдало невалидный access_token');
        }

        return $accessToken;
    }

    private function getDefaultHttpClient(): ClientInterface
    {
        return new Client([
            'allow_redirects' => true,
        ]);
    }

    private function oauth(): Oauth
    {
        return new Oauth($this->base_endpoint, $this->httpClient);
    }

    public function user(): User
    {
        return new User($this->base_endpoint, $this->accessToken, $this->httpClient);
    }

    public function courseSessions(): CourseSessions
    {
        return new CourseSessions($this->base_endpoint, $this->accessToken, $this->httpClient);
    }

}
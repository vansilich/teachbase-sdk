<?php

namespace Teachbase\Endpoint;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientExceptionInterface;
use Teachbase\DTO\User as UserDto;
use \Psr\Http\Client\ClientInterface;
use Teachbase\Exceptions\ApiError;

class CourseSessions{

    private array $defaultHeaders = [];

    public function __construct(
        private string $base_endpoint,
        string $access_token,
        private ClientInterface $httpClient
    ){
        $this->defaultHeaders['Authorization'] = 'Bearer ' . $access_token;
    }

    /**
     * Записываем пользователя на сессию курса по его user id
     * 
     * @throws ApiError|ClientExceptionInterface
     */
    public function registerUser(int $sessionId, int $teachbaseUserId): void
    {
        $endpointUrl = $this->base_endpoint . '/endpoint/v1/course_sessions/' . $sessionId . '/register';

        $headers = [
            ...$this->defaultHeaders,
            'Content-Type' => 'application/json'
        ];
        $request = new Request('POST', $endpointUrl, $headers, json_encode([
            'user_id' => $teachbaseUserId
        ]));

        $response = $this->httpClient->sendRequest($request);
        $responseBody = json_decode($response->getBody()->getContents());

        if ($response->getStatusCode() === 403) {
            // Пользователь уже существует в событии
            return;
        }

        if ($response->getStatusCode() >= 400){
            throw new ApiError(
                implode(', ', $responseBody->errors), 
                $response->getStatusCode()
            );
        }
    }

}
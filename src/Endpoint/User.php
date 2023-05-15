<?php

namespace Teachbase\Endpoint;

use Exception;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientExceptionInterface;
use Teachbase\DTO\User as UserDto;
use \Psr\Http\Client\ClientInterface;
use Teachbase\Exceptions\ApiError;

class User{

    private array $defaultHeaders = [];

    public function __construct(
        private string $base_endpoint,
        string $access_token,
        private ClientInterface $httpClient
    ){
        $this->defaultHeaders['Authorization'] = 'Bearer ' . $access_token;
    }

    /**
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function create(string $email, ?string $name = null, ?string $lastName = null): UserDto
    {
        $endpointUrl = $this->base_endpoint . '/endpoint/v1/users/create';

        $headers = [
            ...$this->defaultHeaders,
            'Content-Type' => 'application/json'
        ];
        $request = new Request('POST', $endpointUrl, $headers, json_encode([
            'users' => [
                [
                    'email' => $email,
                    'name' => $name,
                    'last_name' => $lastName,
                    'role_id' => 1,
                    'auth_type' => 0,
                    'external_id' => null
                ]
            ],
            'options' => [
                    'activate' => false,
                    'verify_emails' => true,
                    'skip_notify_new_users' => false,
                    'skip_notify_active_users' => false
            ]
        ]));

        $response = $this->httpClient->sendRequest($request);
        $responseBody = json_decode($response->getBody()->getContents());

        if ($response->getStatusCode() >= 400){
            throw new ApiError($responseBody->error, $response->getStatusCode());
        }

        if (empty($responseBody)) {
            throw new \RuntimeException('Api Teachbase не прилслало информацию о дабавлении пользователя');
        }

        $user = $responseBody[0];

        return (new UserDto())
            ->setTeachbaseId($user->id)
            ->setEmail($user->email)
            ->setPhone($user->phone)
            ->setName($user->name)
            ->setLastName($user->last_name)
            ->setRoleId($user->role_id)
            ->setAuthType($user->auth_type)
            ->setLang($user->lang)
            ->setLastActivityAt($user->last_activity_at)
            ->setIsActive($user->is_active)
            ->setCreatedAt(new \DateTimeImmutable($user->created_at))
            ->setUpdatedAt(new \DateTimeImmutable($user->updated_at))
            ->setExternalId($user->external_id)
            ->setLocked($user->locked);
    }

}
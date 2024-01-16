<?php

namespace Linear\Sdk;

use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Exception;

class Client
{
    protected PendingRequest $http;
    public function __construct(string $token)
    {
        $client = new Factory();
        $this->http = $client->baseUrl('https://api.linear.app/graphql')
            ->withHeaders(
                [
                    'Authorization' => $token
                ]
            );
            //->withHeader('Authorization', $token); Only works with illuminate/http > 10 and Flarum needs 8
    }

    public function process(Response $response): mixed
    {
        if ($response->failed()) {
            throw new Exception((string) $response->body());
        }

        $json = $response->json();
        if (isset($json['errors'])) {
            throw new Exception((string) $response->body());
        }

        return $response->json('data');
    }

}
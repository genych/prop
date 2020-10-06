<?php declare(strict_types=1);

namespace Pr\Api;

class Client
{
    public function __construct(private string $key) {}

    public function fetchProperties(?string $url = null): array
    {
        $endpoint = getenv('SOME_SERVICE_URL');
        $response = file_get_contents($url ?? "$endpoint?api_key=$this->key");
        return json_decode($response, true);
    }
}

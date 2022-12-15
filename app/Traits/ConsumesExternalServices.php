<?php

namespace App\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

trait ConsumesExternalServices
{
    use LogTrait;

    /**
     * @return string[]
     */
    private function headersDefault(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    /**
     * @param string $method
     * @param array $headers
     * @param array $body
     * @return array
     */
    private function selfParameters(string $method, array $headers = [], array $body = []): array
    {
        $method = strtoupper($method);
        $parameters = [];

        $parameters["headers"] = !empty($headers) ? $headers : $this->headersDefault();

        if (!empty($body) && ($method != "GET" && $method != "DELETE")) {
            $parameters["body"] = json_encode($body);
        }
        return $parameters;
    }

    /**
     * @param string $className
     * @param string $methodName
     * @param string $methodHttp
     * @param string $url
     * @param array $headers
     * @param array $body
     * @return mixed
     */
    public function performRequest(string $className, string $methodName, string $methodHttp, string $url, array $headers = [], array $body = []): mixed
    {
        $client = new Client();
        $method = strtoupper($methodHttp);
        $parameters = $this->selfParameters($method, $headers, $body);
        try {
            $response = $client->request($method, $url, $parameters);
            $data = json_decode($response->getBody()->getContents(), true);
            $this->createLog($className, $method, $parameters, $url, $data);
            return $data;
        } catch (GuzzleException $exception) {
            $this->createLog($className, $method, $parameters, $url, $exception);
            return null;
        }
    }

    /**
     * @param string $class
     * @param string $method
     * @param array $parameters
     * @param string $url
     * @param $response
     * @return void
     */
    private function createLog(string $class, string $method, array $parameters, string $url, $response): void
    {
        $parameters['url'] = $url;
        $response = $response instanceof GuzzleException ? $response->getMessage() : $response;
        $this->newLog($class, $method, $parameters, $response);
    }
}

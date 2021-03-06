<?php

declare(strict_types=1);

namespace Furious\Psr7\Factory;

use Furious\Psr7\Header\HeadersCollection;
use Furious\Psr7\Protocol\Protocol;
use Furious\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;

class ServerRequestFactory implements ServerRequestFactoryInterface
{
    public function createServerRequest(string $method, $uri, array $serverParams = []): ServerRequestInterface
    {
        return new ServerRequest($method, $uri,'1.1', [], [], [], $serverParams);
    }

    public function fromGlobals(): ServerRequest
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = $_SERVER['REQUEST_URI'] ?? '';
        $protocolVersion = (new Protocol())->getVersion($_SERVER);
        $headers = (new HeadersCollection($_SERVER))->get();
        $body = 'php://input';

        return new ServerRequest(
            $method,
            $uri,
            $protocolVersion,
            $headers,
            $_GET,
            $body,
            $_SERVER,
            $_COOKIE,
            $_FILES, []
        );
    }
}
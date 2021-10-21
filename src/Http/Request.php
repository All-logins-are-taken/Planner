<?php

declare(strict_types=1);

namespace App\Http;

class Request
{
    public array $parameters;
    public string $requestMethod;
    public string $contentType;

    public function __construct(array $parameters = [])
    {
        $this->parameters = $parameters;
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->contentType = $_SERVER['CONTENT_TYPE'] ?? '';
    }

    public function getBody(): array
    {
        if ($this->requestMethod !== 'POST') {
            return [];
        }
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        return $_POST;
    }

    public function getRequest(): string
    {
        if ($this->requestMethod !== 'POST') {
            $paths = explode('/', $_SERVER['REQUEST_URI']);

            return $paths[count($paths) - 1];
        }

        if (strcasecmp($this->contentType, 'application/json') !== 0) {
            $paths = explode('/', $_SERVER['REQUEST_URI']);

            return $paths[count($paths) - 1];
        }

        return trim(file_get_contents("php://input"));
    }
}

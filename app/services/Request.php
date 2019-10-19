<?php

namespace app\services;

use \Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\ParameterBag;

class Request extends SymfonyRequest
{
    public function __construct()
    {
        parent::__construct($_GET, $_POST, [], $_COOKIE, $_FILES, $_SERVER);

        if (0 === strpos($this->headers->get('CONTENT_TYPE'), 'application/x-www-form-urlencoded')
            && \in_array(strtoupper($this->server->get('REQUEST_METHOD', 'GET')), ['PUT', 'DELETE', 'PATCH'])
        ) {
            parse_str($this->getContent(), $data);
            $this->request = new ParameterBag($data);
        }

    }

    public function isPost() {
        return ('POST' === $this->getMethod());
    }
}
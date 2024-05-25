<?php
namespace Api\View;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CoreView
{
    public function home(Request $request, Response $response, array $args): Response
    {
        $response->getBody()->write("Welcome to simple bank api!");
        return $response;
    }
}

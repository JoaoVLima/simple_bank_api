<?php
namespace Api\View;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpException;
use Api\Controller\BankController;

class BankView
{
    public function reset(Request $request, Response $response, array $args): Response
    {
        $banco = new BankController();
        $banco->reset();
        $response->getBody()->write('OK');
        $response = $response->withStatus(200);
        return $response;
    }

    public function balance(Request $request, Response $response, array $args): Response
    {
        $banco = new BankController();
        $params = $request->getQueryParams();
        $account = $banco->getAccount($params['account_id']);
        if (!$account){
            $response->getBody()->write('0');
            $response = $response->withStatus(404);
            return $response;
        }
        $balance = $account->getBalance();
        $response->getBody()->write(strval($balance));
        $response = $response->withStatus(200);
        return $response;
    }

    public function event(Request $request, Response $response, array $args): Response
    {
        $banco = new BankController();
        $params = json_decode($request->getBody()->getContents(),true);
        $event = $params['type'];
        unset($params['type']);
        $banco->$event(...$params);

        $response->getBody()->write("Welcome to simple bank api!");
        return $response;
    }
}

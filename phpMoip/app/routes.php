<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;



return function (App $app) {
    $app->addBodyParsingMiddleware();
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    /* EXEMPLO OLA MUNDO */
    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->get('/customers', function (Request $request, Response $response) {
        $USER = "MASQPX7MT7MK8TK2SPTMBK56GMHJ4WGP";
        $PASSWORD = "VM8EDI6INU5AFFGQ71R92RYKUVRU2GB1GTBXAM6T";
        $URL = "https://sandbox.moip.com.br/v2/";
        $ch = curl_init("{$URL}customers");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "{$USER}:{$PASSWORD}");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_VERBOSE, TRUE);
        $result = curl_exec($ch);
        $errors = curl_error($ch);
        curl_close($ch);
        if ($result === FALSE) {
            $response->getBody()->write($errors);
            return $response->withHeader('Content-Type', 'application/json')->withStatus(405);
        } else {
            $response->getBody()->write($result);
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        }
    });


   function getConsultCustomer(){
        $USER = "MASQPX7MT7MK8TK2SPTMBK56GMHJ4WGP";
        $PASSWORD = "VM8EDI6INU5AFFGQ71R92RYKUVRU2GB1GTBXAM6T";
        $URL = "https://sandbox.moip.com.br/v2/";
        $id = "CUS-VL3OA0C38143";
        $ch = curl_init("{$URL}customers/{$id}");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "{$USER}:{$PASSWORD}");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_VERBOSE, TRUE);
        $result = curl_exec($ch);
        $errors = curl_error($ch);
        if ($result === FALSE) {
            return $errors;
        } else {
            return $result;
        }
        
    }


    $app->post('/payment', function (Request $request, Response $response) {
        $data = $request->getParsedBody();
        $res = getConsultCustomer();
        $json = json_decode($res, TRUE);
        if (!empty($json['error'])) {
            $response->getBody()->write($res);
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } else {
            $response->getBody()->write(json_encode($data['customer']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        }
        
        
    });
};

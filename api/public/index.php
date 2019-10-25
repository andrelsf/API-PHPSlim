<?php

use App\Models\UserRepository;
use Doctrine\ORM\EntityManager;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require __DIR__."/../bootstrap.php";

/**
 * GET: /users
 * Lista de todos os usuários
 * @CURL:
 *      curl -X GET localhost:/users
 */
$app->get('/users', function (Request $request, Response $response) use ($app) {
    $entityManager = $this->get(EntityManager::class);
    $userRespository = new UserRepository($entityManager);
    $usersList = $userRespository->getUsers();
    $message = [
        'status' => 'success',
        'message' => $usersList
    ];
    return $response->withJson($message, 200)
                    ->withHeader('Content-Type', 'application/json');
});

/**
 * GET: /user/{id}
 * Busca um usuario pelo ID e detalha suas informações
 */
$app->get('/user/{id}', function (Request $request, Response $response) use ($app) {
    $route = $request->getAttribute('route');
    $id = $route->getArgument('id');
    $message = [
            'status' => 'success',
            'message' => "User {$id}"
    ];
    return $response->withJson($message, 200)
                    ->withHeader('Content-Type', 'application/json');
});

/**
 *  POST: /user
 *  Registra um novo usuário
 */
$app->post('/user', function (Request $request, Response $response) use ($app) {
    $message = [
            'status' => 'success',
            'message' => 'POST: Ususario cadastrado'
    ];
    return $response->withJson($message, 201)
                    ->withHeader('Content-Type', 'application/json');
});

/**
 * PUT: /user/{id}
 * Atualiza o registro de um usuario pelo id.
 */
$app->put('/user/{id}', function (Request $request, Response $response) use ($app) {
    $route = $request->getAttribute('route');
    $id = $route->getArgument('id');

    $message = [
            'status' => 'success',
            'message' => "Usuario {$id} atualizado"
    ];

    return $response->withJson($message, 200)
                    ->withHeader('Content-Type', 'application/json');
});

/**
 * DELETE: /user/{id}
 * Remove um usuario
 */
$app->delete('/user/{id}', function (Request $request, Response $response) use ($app) {
    $route = $request->getAttribute('route');
    $id = $route->getArgument('id');

    $message = [
            'status' => 'success',
            'message' => "Usuario {$id} removido."
    ];

    return $response->withJson($message, 204)
                    ->withHeader('Content-Type', 'application/json');
});

/**
 * Executa a aplicação
 */
$app->run();
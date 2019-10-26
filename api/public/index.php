<?php

use App\Models\UserRepository;
use Doctrine\ORM\EntityManager;
use Psr7Middlewares\Middleware\TrailingSlash;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require __DIR__."/../bootstrap.php";

/**
 * @middleware
 * Tratamento do barra(/) na request
 * true: adiciona a barra(/) no final da URL
 * false: remove a barra(/) do final da URL
 */
$app->add(new TrailingSlash(false));

/**
 * Monolog: for all methods 
 */


/**
 * GET: /users
 * Lista de todos os usuários
 * @CURL:
 *      curl -X GET localhost:/users
 */
$app->get('/users', function (Request $request, Response $response) use ($app) {
    $logger = $this->get('logger');
    
    $entityManager = $this->get(EntityManager::class);
    $userRespository = new UserRepository($entityManager);
    $usersList = $userRespository->getUsers();
    $message = [
        'status' => 'success',
        'users' => $usersList
    ];

    $logger->info("GET Users");

    return $response->withJson($message, 200, JSON_PRETTY_PRINT)
                    ->withHeader('Content-Type', 'application/json;charset=utf-8');
});

/**
 * [GET, PUT, DELETE]: /user/{id}
 * @method GET: curl -X GET localhost/user/1
 * @method DELETE: curl -X DELETE localhost/user/1
 * @method PUT: curl -X PUT -H "Content-Type: application/json" -d '{"fullname":"Andre Ferreira","email":"andre.ferreira@soluti.com.br","password":"admin123","isactive":false}' localhost/user
 * 
 * @method MAP add methos in unique endpoint
 */
$app->map(
        ['GET', 'DELETE'], '/user/{id:[0-9]+}', 
        function (Request $request, Response $response
    ) use ($app) {
    $logger = $this->get('logger');

    $route = $request->getAttribute('route');
    $id = $route->getArgument('id');
    
    $entityManager = $this->get(EntityManager::class);
    $userRespository = new UserRepository($entityManager);
    
    $message = [];
    
    if ($request->isGet()) {
        
        $user = $userRespository->getOneUser($id);
        $message['message'] = $user['message'];
        $message['status'] = $user['code'];

        $logger->info("GET User {$id}");
    } elseif ($request->isDelete()) {
        
        $user = $userRespository->deleteOneUser($id);
        $message['message'] = $user['message'];
        $message['status'] = $user['code'];
        
        $logger->info("DELETE User: {$id}");
    }

    return $response->withJson($message, (int) $message['status'], JSON_PRETTY_PRINT)
                    ->withHeader('Content-Type', 'application/json');
});

/**
 *  POST: /user
 *  Registra um novo usuário
 */
$app->post('/user', function (Request $request, Response $response) use ($app) {
    $logger = $this->get('logger');

    $message = [];
    
    $post = (object) $request->getParams();

    $entityManager = $this->get(EntityManager::class);
    $userRespository = new UserRepository($entityManager);
    
    $userExists = $userRespository->findByEmail($post->email);
    
    if (!$userExists) {
        $result = $userRespository->addUser(
                $post->fullname,
                $post->email,
                $post->password,
                (bool) $post->isactive
        );
        if ($result) {
            $message['message'] = 'User add with successfully';
            $message['code'] = 201;
            $logger->info("POST: {$message['message']}");
        }
    } else {
        $message['message'] = 'email already exists';
        $message['code'] = 404;

        $logger->info("POST: {$message['message']}");
    }
    
    return $response->withJson($message, (int) $message['code'], JSON_PRETTY_PRINT)
                    ->withHeader('Content-Type', 'application/json');
});

/**
 * Executa a aplicação
 */
$app->run();
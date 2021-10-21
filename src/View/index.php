<?php
require_once __DIR__.'/../../vendor/autoload.php';

use App\Container\ServiceContainer;
use App\Controller\ProjectController;
use App\Http\Router;
use App\Http\Request;
use App\Http\Response;

$container = new ServiceContainer(['path' => __DIR__.'/../../.env']);
$project = new ProjectController($container);

Router::get('/', function (Request $request, Response $response) use ($project) {
    $response->getResponse($project->index());
});

Router::post('/', function (Request $request, Response $response) use ($project) {
    $request->getBody()['action'] ?? header('Location: /');
    $action = $request->getBody()['action'];

    if ($action === 'import') {
        $response->getResponse($project->import());
    }
    else {
        header('Location: /');
    }
});

Router::get('/project/\d', function (Request $request, Response $response) use ($project) {
    $response->getResponse($project->preview($request->getRequest()));
});

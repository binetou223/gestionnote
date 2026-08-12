<?php

$routes =[
    '/'=>[
        'controller'=>'afficheNote',
        'action'=>'affichevue'
    ],
    '/login'=>[
        'controller'=>'authentification',
        'action'=>'login'
    ]


];

    $uri = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
    $route=$routes[$uri]??$routes['/'];

    $controller=$route['controller'];
    $action=$route['action'];
//     var_dump($action);
// die;
    if(file_exists(dirname(__DIR__)."/controller/".$controller.".php")){
        require_once dirname(__DIR__)."/controller/afficheNote.php";
        require_once dirname(__DIR__)."/controller/authentification.php";
        if(function_exists($action)){
            $action();
        }
    }
    else{
        http_response_code(404);
        echo "Page not found";
    }
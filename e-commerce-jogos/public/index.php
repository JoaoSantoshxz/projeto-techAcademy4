<?php

require_once '../app/Models/Conexao.php'; 
require_once '../app/Controllers/ClienteController.php';
require_once '../app/Controllers/ProdutoController.php';


$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
echo "DEBUG URI LIDA: " . $uri . "<br>"; 
die();
$url_parts = explode('/', trim($uri,'/'));

$controller_name = !empty($url_parts[0]) ? ucfirst($url_parts[0]) . 'controller' : 'ProdutoController';
$action_name = !empty($uri_parts[1]) ? $uri_parts[1] : 'index';


$controller_path = '../app/Controllers/' . $controller_name . '.php';

if (file_exists($controller_path)) {
    require_once $controller_path;
    $controller = new $controller_name();

    if (method_exists($controller, $action_name)) {
        $controller->$action_name();
    } else {
        echo "Ação não encontrada!";
    }
} else {
    echo "Pagina não encontrada!";
}

?>
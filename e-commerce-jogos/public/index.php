<?php

require_once '../config.php';
require_once '../app/Model/Conexao.php';

$url = $_SERVER['REQUEST_URL'];
$url_parts = explode('/', trim($url,'/'));

$controller_name = !empty($url_parts[0]) ? ucfirts($url_parts[0]) . 'controller' : 'ProdutoController';
$action_name = !empty($url_parts[1]) ? $url_parts[1] : 'index';


$controller_path = '../app/Controllers/' . $controller_name . '.php';

if (file_exist($controller_path)) {
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
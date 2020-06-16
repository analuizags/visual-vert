<?php

    require_once '../config.php';
    require_once "../core/controller/Api.php";
    require_once "../core/controller/Visualizacoes.php";    
    require_once "../core/model/Visualizacao.php";    
    require_once "../core/sistema/Requisicao.php";

    use core\controller\Api;

    $api = new Api();
    $api->init();
    
?>
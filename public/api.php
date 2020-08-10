<?php

    require_once '../config.php';
    require_once "../core/controller/Api.php";
    require_once "../core/sistema/Requisicao.php";

    use core\controller\Api;

    $api = new Api();
    $api->init();
    
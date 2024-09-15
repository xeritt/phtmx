<?php
require_once "../bootstrap.php";

//include_once '../autoload.php';

Config::setEntityManager($entityManager);

$app = new Application();
$app->run();

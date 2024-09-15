<?php
// bootstrap.php
require_once "vendor/autoload.php";

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

$paths = [__DIR__.'/src/App/Model'];
$isDevMode = true;

// the connection configuration
$dbParams = [
	'driver'   => 'pdo_mysql',
	'user'     => 'phtmx',
	'password' => 'phtmx',
	'dbname'   => 'phtmx_start',
	'host' => 'php_db'
];

$config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);
$connection = DriverManager::getConnection($dbParams, $config);
$entityManager = new EntityManager($connection, $config);

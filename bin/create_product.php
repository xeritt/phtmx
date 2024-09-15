<?php
//namespace App;
// create_product.php <name>
//require_once "../bootstrap.php";
//use App\Model\Product;
require_once __DIR__ . '/../bootstrap.php';


//use App\Model\Product;
//use app\model\Product;

$newProductName = $argv[1];

$product = new App\Model\Product();
$product->setName($newProductName);

$entityManager->persist($product);
$entityManager->flush();

echo "Created Product with ID " . $product->getId() . "\n";



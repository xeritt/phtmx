<?php
// list_products.php
require_once "../bootstrap.php";
//echo __DIR__;
$productRepository = $entityManager->getRepository('Product');
$products = $productRepository->findAll();

foreach ($products as $product) {
    echo sprintf("%d-%s\n", $product->getId(), $product->getName());
}

$properties = $entityManager->getClassMetadata('Product')->getFieldNames();
print_r($properties);


$table = $entityManager->getConnection()->getSchemaManager()->listTableDetails('product');
print_r($table);

$conn = $entityManager->getConnection();
$schemaManager = $conn->createSchemaManager();


$columns = $schemaManager->listTableColumns('products');
echo "!";
foreach ($columns as $column) {
    //echo $column->getName() . ': ' . $column->getType()->getName() . "\n";
    echo $column->getName() . ': ' . $column->getType()->getName() . " ".$column->getComment()."!!\n";
}
echo "?";
/*$output = array_merge(
              $properties, 
              $entityManager->getClassMetadata('Product')->getAssociationNames()
);
*/
//print_r($ls);
echo $columns['name']->getComment();


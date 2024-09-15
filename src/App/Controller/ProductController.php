<?php

//use App\Core\Model\Product;
/** Продукт */
class ProductController extends BaseController{

    public function getTable() {
        $html = '';
        echo "???";
        //$product = new App\Core\Model\Product();
        echo "!!!!";
        $entityManager = Config::getEntityManager();
        $productRepository = $entityManager->getRepository('Product');
        $products = $productRepository->findAll();
        
        $table = new DoctrineTable($products);
        $modelName = $this->getModelName();
        $table->setModelName($modelName);
        $html .= $table->getHTML();
        
        /*
        $modelName = $this->getModelName();
        echo $modelName;
        
        $data  = new Data($this->getModelFileName());
        $ids = $data->readDataFile();
        
        $table = new Table($ids["data"]);
        $table->setModelName($modelName);
        $table->setClass($modelName);
        return $table;
        */
        
        /*
        
        
        $entityManager = Config::getEntityManager();
        $productRepository = $entityManager->getRepository('Product');
        $products = $productRepository->findAll();

        foreach ($products as $product) {
            $html .= sprintf("%d-%s\n", $product->getId(), $product->getName());
        }
        $k = array_keys($products);
        
        //$reflectionClass = new ReflectionClass(Product::class);
        //$property = $reflectionClass->getProperty('name');
        
        $reflect = new ReflectionClass('Product');
        $props   = $reflect->getProperties(ReflectionProperty::IS_PRIVATE);
        e::p($props);
         * 
         */
        return $html;
    }
    
    public function getItems() {
        $html = '';
        $modelName = $this->getModelName();
        $html .= $this->getTable();
        //$html .= $table->getColTableHTML();

        $add = new Button("+ ".$modelName, "myDialog", Url::go($modelName."/add"), "loadDialog");
        $html .= $add->getHTML();
        
        $html .= HTML::br();
        $html .= HTML::br();
        return $html;
    }


}

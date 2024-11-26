<?php
use Doctrine\Common\Annotations\AnnotationReader;
/**
 * Description of AuthorController
 *
 */
class BookController extends BaseController{
    
    public function getItems() {
        $modelName = $this->getModelName();
        $data  = new Data($modelName.'.json');
        $ids = $data->readDataFile();
        $table = new Table($ids["data"]);
        $table->setModelName($modelName);
        $table->setStyle("color:red; border: 1px solid green;");
        $table->setClass("table");
        echo $table->getColTableHTML();
        //echo $table->getRowTableHTML();
        //print_r($ids);
        //echo HTML::br();
        

        //$add = new Button("Add", 'main', "load.php?page=Book&action=add");
        $add = new Button("+ ".$modelName, "myDialog", Url::go($modelName."/add"), "loadDialog");
        echo $add->getHTML();
        $doctrine = new Button("doctrine", "myDialog", Url::go($modelName."/doctrine"), "loadDialog");
        echo $doctrine->getHTML();
        echo HTML::br();
        echo HTML::br();
    }
    
    public function doctrineAction() {
        $entityManager = Config::getEntityManager();
        $productRepository = $entityManager->getRepository('Product');
        $products = $productRepository->findAll();

        foreach ($products as $product) {
            echo sprintf("%d-%s\n", $product->getId(), $product->getName());
        }
        
       
        
        $reflectionClass = new ReflectionClass(Product::class);
        $property = $reflectionClass->getProperty('name');

        $reader = new AnnotationReader();
        
        $annotation = $reader->getPropertyAnnotation(
            $property,
            InputAnnotation::class
        );

        echo $annotation->class;
        echo $annotation->title;
        echo $annotation->label;
        /*
        $titleAnnotation = $reader->getPropertyAnnotation(
            $property,
            InputTitleAnnotation::class
        );
        echo $titleAnnotation->value;
        echo "??";
         * 
         */
    }
}

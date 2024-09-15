<?php


//include_once 'autoload.php';
//$path = "model\\Rules";
//$rules = new model\Rules();
//$rules = new Rules();
//print_r($rules);
//$model = Model::create("Book");
//$arr = Model::getArrayPrivates("Book");
//print_r($arr);
/*
class  TestClass { 
    
    public function hello() {
        echo "Hello";
    }
}

$name = 'TestClass';
$TestObj = new $name();
$TestObj->hello();

var_dump($TestObj);

$TestObj_assigned = $TestObj;
$TestObj_Refrenced = &$TestObj;
$TestObj_cloned = clone $TestObj;

$obj = new ReflectionClass('TestClass');
echo "1";
var_dump($obj->isInstance($TestObj)); 
var_dump($obj->isInstance($TestObj_assigned)); 
var_dump($obj->isInstance($TestObj_Refrenced)); 
var_dump($obj->isInstance($TestObj_cloned));
*/
/*
class foo {
    private $a;
    public $b = 1;
    public $c;
    private $d;
    static $e;
   
    public function test() {
        var_dump(get_object_vars($this));
    }
}

include_once 'model/Book.php';
$test = new Book();
var_dump(get_object_vars($test));
*/
//$test->test();

 //$filename = "/var/www/html/jsonlib/tpl/phtmx/ModelController.php";
 //$filename = "tpl/phtmx/ModelController.php";
 //$text = htmlspecialchars(file_get_contents($filename));
 //echo $text;

/*
 $types = [
            "boolean",
            "int",
            "integer",
            "double",
            "float",
            "string",
            "array",
            "object",
            "resource",
            "NULL",
            "unknown type"
        ];   
 $name = '';
 $res = in_array($name, $types);
 echo 'res =';
 if (!in_array($name, $types)){
    var_dump($res);    
 } else {
     echo "?????";
 }
 */
 
 $var_array = array(
    "color" => "blue",
    "size"  => "medium",
    "shape" => "sphere"
 );

 extract($var_array);

 ob_start();              // start output buffer 1
 require_once 'test2.php';
 $out = ob_get_clean();
 echo $out;
 //echo "a";                // fill ob1
 //$s1 = ob_get_contents(); // read ob2 ("b")
 
 //
 //       ob_start();              // start output buffer 2
   //     echo "b";                // fill ob2
     //   $s1 = ob_get_contents(); // read ob2 ("b")
       // ob_end_flush();          // flush ob2 to ob1
        
    //echo "c";                // continue filling ob1
    //$s2 = ob_get_contents(); // read ob1 ("a" . "b" . "c")
    //ob_end_flush();          // flush ob1 to browser
    
    // echoes "b" followed by "abc", as supposed to:
    //echo "<HR>$s1<HR>$s2<HR>";
 
?>

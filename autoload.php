<?php
    
    spl_autoload_register(function($class){
    //echo $class;
            
    $pos = strpos($class, "\\");

    // Обратите внимание, что значения сравниваются оператором ===. Оператор == не будет работать
    // как ожидается, поскольку позиция символа «a» — первого по счёту символа — равнялась 0.
    if ($pos === false) {
        
        $paths = [
            '../src/App/Annotation/'.$class.'.php',
            '../src/App/Interface/'.$class.'.php',
            '../src/App/Core/'.$class.'.php',
            //'../class/'.$class.'.php',
            '../src/App/Core/Form/'.$class.'.php',
            '../src/App/Model/'.$class.'.php',
            '../src/App/controller/'.$class.'.php'
        ];
        foreach ($paths as $path) {
            if (file_exists($path)){
                //echo $path;
                //exit();
                require_once($path);
                break;
            }   
        }
        
        //use App\CSS;
        
        //$use_path = [
          //  use App\ ;//'../core/'.$class.'.php',
        //];
        
        //echo "Функция не нашла подстроку";
    } else {
        //echo str_replace("\\", "/", $class);
        $fileClass = str_replace("\\", "/", $class);
        
        if (class_exists($fileClass)) return;
            
        $fileClassPHP = '../'.$fileClass.'.php';
        
        echo "2[".$fileClassPHP."]2";
        //exit();
        
        if (file_exists($fileClassPHP)){
            //echo 'use '.$class.';';
            //eval ('use '.$class.';');
            echo "3[".$fileClass."]3";
            require_once($fileClassPHP);
        }
        //echo "Функция нашла подстроку «{$findme}» в строке «{$mystring}»";
        //echo " в позиции $pos";
    }


    });

<?php

/**
 * Description of CssController
 *
 */
class CssController {
    //put your code here
    
    public function loadAction() {
        $className = HTML::get('class');
        $obj = new $className();
        $css = $obj->getStyle();
        $style = HTML::tag($css, 'style', ['id'=>$className.'Style','class'=>'dynamicStyle']);
        return $style;        
        //return '<style>.hide{
          //      display: none;
            //}</style>';
        //return "<style>??</style>";
    }
}

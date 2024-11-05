<?php

/** Заказ */
class OrderController extends DoctrineController{
    public $actionButtons = [];
    
    public function __construct() {
        parent::__construct();

        $this->actionButtons['index'][] = function ($id){
            $modelName = Url::getModel();
            $view = new Button("View", $modelName, '', 'linkButton');
            $view->setHref(Url::go($modelName."/view", ["id"=>$id]));
            return $view;
        };
    }

    public function viewAction() {
        $html = '';
        
        $id = HTML::get('id');
        $html .= 'view id = '.$id;
        
        $service = new OrderServiceController();
        $content = $service->getItems('OrderService', ['order'=>$id]);
        $html .= HTML::tag($content, 'div', ['id'=>'OrderService']);
        
        $wood = new OrderWoodController();
        $content = $wood->getItems('OrderWood', ['order'=>$id]);
        $html .= HTML::tag($content, 'div', ['id'=>'OrderWood']);
        
        
        $view = new View();
        $title = 'Заказ #'.$id;
        $content = $view->render('default/view', ['model'=>$this->getModelName(), 'content'=>$html]);
        echo $view->renderLayout('default/main', ['title'=>$title, 'content'=>$content]);
    }
    
}

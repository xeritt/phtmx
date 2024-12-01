<?php

/** Заказ */
class OrderController extends DoctrineController{
    public $actionButtons = [];
    
    public function __construct() {
        parent::__construct();

        $this->actionButtons['index'][] = function ($id){
            $modelName = Url::getModel();
            $view = new Button("View", $modelName, '', 'linkButton');
            $view->setHref(Url::go($modelName."/view", ["order_id"=>$id]));
            return $view;
        };
    }
    
    public function orderSummaryAction() {
        $order_id = HTML::get('order_id');
        $sumWood = $this->orderWoodSum($order_id);
        $sumService = $this->orderServiceSum($order_id);
        
        $summary = (int)($sumWood + $sumService);
        //$action = URL::getAction();
        //$model = URL::getModel();
        $html = 'ИТОГО: '.$summary.' руб.';
        return HTML::tag($html, 'div', [
            'id'=>'orderSummary', 
            'class'=>'loadByClick', 
            'data-models'=>'OrderService, OrderWood',
            'data-actions'=>'new,update,del',
            'data-url'=>URL::go('Order/orderSummary', ['order_id'=>$order_id])
        ]);
    }
    
    public function orderServiceSum($order_id) {
        $entityManager = Config::getEntityManager();
        $repository = $entityManager->getRepository('OrderService');
        $items = $repository->findBy(['order'=>$order_id]);
        $sum = 0;
        foreach ($items as $row) {
            $sum += $row->getService()->getCost() * $row->getCount();
        }
        return $sum;
    }
    
    public function orderServiceSumAction() {
        $order_id = HTML::get('order_id');
        $sum = $this->orderServiceSum($order_id);
        $html = 'Сумма: '.$sum.' руб.';
        //$model = URL::getModel();
        //$action = URL::;        
        $html = HTML::tag($html, 'div', [
            'id'=>'orderServiceSum', 
            'class'=>'loadByClick', 
            'data-models'=>'OrderService',
            'data-actions'=>'new,update,del',
            'data-url'=>URL::go('Order/orderServiceSum', ['order_id'=>$order_id])
        ]);
        return $html;
    }
    
    public function getOrderServices($order_id) {
        $html = '';
        //$entityManager = Config::getEntityManager();
        $service = new OrderServiceController();
        $content = $service->getItems('OrderService', ['order'=>$order_id]);
        $html .= HTML::tag($content, 'div', ['id'=>'OrderService']);
        return ['html'=>$html/*, 'sum'=>$sumService*/];
    }
    
    public function orderWoodSum($order_id) {
        $entityManager = Config::getEntityManager();
        $repository = $entityManager->getRepository('OrderWood');
        $items = $repository->findBy(['order'=>$order_id]);
        $sum = 0;
        foreach ($items as $row) {
            $sum += $row->getWood()->getCost() * $row->getCount();
        }
        return $sum;
    }
    
    public function orderWoodSumAction() {
        $order_id = HTML::get('order_id');
        $sum = $this->orderWoodSum($order_id);
        $html = 'Сумма: '.$sum.' руб.';
        $model = 'OrderWood';
        $action = 'update';        
        $html = HTML::tag($html, 'div', [
            'id'=>'orderWoodSum', 
            'class'=>'loadByClick', 
            'data-models'=>'OrderWood',
            'data-actions'=>'new,update,del',
            'data-url'=>URL::go('Order/orderWoodSum', ['order_id'=>$order_id])
        ]);
        return $html;
    }
    
    public function getOrderWoods($order_id) {
        $html = '';
        //$entityManager = Config::getEntityManager();
        
        $wood = new OrderWoodController();
        $content = $wood->getItems('OrderWood', ['order'=>$order_id]);
        $html .= HTML::tag($content, 'div', ['id'=>'OrderWood']);
        /*
        $orderWoodRepository = $entityManager->getRepository('OrderWood');
        $orderWood = $orderWoodRepository->findBy(['order'=>$order_id]);
        $sumWood = 0;
        foreach ($orderWood as $row) {
            $sumWood += $row->getWood()->getCost() * $row->getCount();
        }
        $html .= 'Сумма: '.$sumWood.' руб.';*/
        return ['html'=>$html/*, 'sum'=>$sumWood*/];
    }
    
    public function viewAction() {
        $html = '';
        
        $order_id = HTML::get('order_id');
        $html .= 'view id = '.$order_id;
        
        $service = $this->getOrderServices($order_id);
        $html .= $service['html'];
        $html .= $this->orderServiceSumAction();
        
        $wood = $this->getOrderWoods($order_id);
        $html .= $wood['html'];
        $html .= $this->orderWoodSumAction();
        $html .= $this->orderSummaryAction();
        
        $view = new View();
        $title = 'Заказ #'.$id;
        $content = $view->render('default/view', ['model'=>$this->getModelName(), 'content'=>$html]);
        e::o ($view->renderLayout('default/main', ['title'=>$title, 'content'=>$content]));
    }
    
}

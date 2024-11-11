<?php

/**
 * Description of Index
 *
 * @author tirex
 */
class IndexController extends Controller {
    
    static public function indexAction() {
        e::o("Index page");
    }
    
    static public function menuAction() {
        if (Access::ifLogin()) {
            $del = ' | ';
            e::o (HTML::link('index.html', 'Index'));
            e::o ($del);
            e::o (HTML::link('rules.html', 'Rules'));
            e::o ($del);
            e::o (HTML::link('user.html', 'Users'));
            e::o ($del);
            e::o (HTML::link(Url::go("Models/main"), 'Models'));
            e::o ($del);
            e::o (HTML::link(Url::go("Login/logout"), 'Logout'));
            e::br();
            e::o (HTML::link(Url::go("Order/main"), 'Заказы'));
            e::o ($del);
            e::o (HTML::link(Url::go("Client/main"), 'Клиенты'));
            e::o ($del);
            e::o (HTML::link(Url::go("OrderStatus/main"), 'Статусы'));
            e::o ($del);
            e::o (HTML::link(Url::go("Wood/main"), 'Товары'));
            e::o ($del);
            e::o (HTML::link(Url::go("Service/main"), 'Сервисы'));
        } else {
            e::o (HTML::link("login.html", 'Login'));
            
        }    
    }

}

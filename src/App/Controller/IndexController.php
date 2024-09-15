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
            e::o (HTML::link('models.html', 'Models'));
            e::o ($del);
            e::o (HTML::link(Url::go("Login/logout"), 'Logout'));
            
        } else {
            echo HTML::link("login.html", 'Login');
            
        }    
    }

}

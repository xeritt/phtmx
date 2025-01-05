<?php

/**
 * Description of LoginController
 *
 */
class LoginController extends Controller{
    
    public function inAction() {
        
        if (Access::ifLogin()){
            $this->indexAction();
            return;
        }
            
        $model = $this->getModelName();
        //echo "?????".$model;
        $item = $this->newItem();
        //$form = new FormBuilder($book, "Book/new");
        $form = new FormBuilder($item, Url::go($model."/new"));//"index.php?page=Book&action=new");
        e::o($form->getForm());
        
        $submit = $form->getSubmit("Войти");
        $submit->setTarget('Flash');
        $submit->setDialogclose('myDialog');
        e::o($submit->getHTML());
        
        $close = new Button("Закрыть", "myDialog", "index.php", "actionClose");
        e::o($close->getHTML());
    }
    
    public function newAction() {
        
        $item = $this->newItem();
        $login = Model::getParamsPrivates($item, HTML::postParams());
        $dataUser  = new Data('User.json');
        $users = $dataUser->readDataFile();
        
        foreach ($users["data"] as $i => $user) {
            $pass = Access::pass($login['password']);
            //$login = $user['login'];
            //print_r($user);
            //echo $pass.$user['login']."!!".$login['login']."!!!";
            if ($user['login'] == $login['login'] && $user['password'] == $pass ){
                $login["id"] = uniqid();
                $login["password"] = "*****";
                $data  = new Data($this->getModelFileName());
                $ids = $data->readDataFile();
                $data->add($login);
                $data->saveDataFile();        
                Access::login($user['login']);
                $this->indexAction();
                return;
                //header("")
                //header("Location: index.html");
                //echo "Login success!! Ok";
                //return;
            }
        }
        
        echo "Login or password wrong!";
    }
    
    public function printAction() {
        //echo "????";
        print_r($_SESSION);
        Access::printSession();
    }
    
    public function indexAction() {
        //echo "Login";
        //print_r($_SESSION);
        Access::printSession();
        e::o(HTML::link("index.html", "index"));
    }
    
    public function logoutAction() {
        Access::logout("admin");
        e::o(HTML::link("index.html", "index"));
    }
}

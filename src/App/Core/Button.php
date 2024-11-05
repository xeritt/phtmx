<?php

//include_once 'Component.php';
/**
 * Description of Button
 *
 */
class Button extends Component{
    private $text;
    private $url;
    private $target;
    private $timeout = 0;
    private $confirm;
    private $script;
    private $form;
    private $dialogclose;
    private $href;

    public function __construct($text, $target, $url, $class = "loadText") {
        parent::__construct($class);
        $this->text = $text;
        $this->url = $url;
        $this->target = $target;
    }

    public function setTimeout($timeout): void {
        $this->timeout = $timeout;
    }
    
    public function setConfirm($confirm): void {
        $this->confirm = $confirm;
    }
    
    public function setScript($script): void {
        $this->script = $script;
    }

    public function setForm($form): void {
        $this->form = $form;
    }
    
    public function setDialogclose($dialogclose): void {
        $this->dialogclose = $dialogclose;
    }

    public function setHref($href): void {
        $this->href = $href;
    }

    public function getHTML() {
        $id = $this->getId();
        $class = $this->getClass();
        $html = "<button 
            id=\"$id\" 
            class=\"$class\" 
            data-url=\"$this->url\" 
            data-target=\"$this->target\"
            data-timeout=\"$this->timeout\"
        ";
        if (isset($this->confirm)) {
            $html .= "data-confirm=\"$this->confirm\"";    
        }
        if (isset($this->script)) {
            $html .= "data-script=\"$this->script\"";    
        }
        if (isset($this->form)) {
            $html .= "data-form=\"$this->form\"";    
        }
        if (isset($this->dialogclose)) {
            $html .= "data-dialogclose=\"$this->dialogclose\"";    
        }
        if (isset($this->href)) {
            $html .= "data-href=\"$this->href\"";    
        }
        $html .= ">$this->text</button>";
        $this->setHtml($html);
        return $html;
    }
}

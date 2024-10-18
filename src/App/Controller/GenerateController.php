<?php

/**
 */
class GenerateController extends BaseController {

    public function head($fileName) {
        e::br();
        e::o('Файл: ' . $fileName);
        e::br();
        e::o('-----------------------------------------');
        e::br();
    }

    public function tail() {
        e::br();
        e::o('^^^^^^^^^^^^^^^^^^^^^^^');
        e::br();
    }

    public function format($fileName, $text) {
        $this->head($fileName);
        e::o($text);
        $this->tail();
    }

    public function newAction() {
        $this->indexAction();

        $id = HTML::post("model");
        $tplPath = '../tpl/phtmx/';
        $dstPath = '../src/App/';

        $fileController = $tplPath . "ModelController.php";
        $text = file_get_contents($fileController);
        $data = new Data("Models.json");
        $ids = $data->readDataFile();
        $obj = $data->getById($id);

        $res = sprintf($text, $obj["comment"], $obj["name"]);
        $fileControllerDest = $dstPath . "Controller/" . $obj["name"] . "Controller.php";
        file_put_contents($fileControllerDest, $res);
        chmod($fileControllerDest, 0775);

        //$this->title($fileControllerDest);
        //echo htmlspecialchars($res);
        //$this->tail();
        $this->format($fileControllerDest, htmlspecialchars($res));

        /*
          $fileModel = $tplPath."model.html";
          $fileModelDest = strtolower($obj["name"]).".html";
          $textModel = file_get_contents($fileModel);
          $res = sprintf($textModel, $obj["name"], $obj["name"], strtolower($obj["name"]));
          file_put_contents($fileModelDest, $res);
          chmod($fileModelDest, 0775);
          //echo htmlspecialchars($res);
          $this->format($fileModelDest, htmlspecialchars($res));
         */
        $fileModel = $tplPath . "model.js";
        $fileModelDest = "js/" . strtolower($obj["name"]) . ".js";
        $textModel = file_get_contents($fileModel);
        $res = sprintf($textModel, $obj["name"], $obj["name"], $obj["name"]);
        file_put_contents($fileModelDest, $res);
        chmod($fileModelDest, 0775);
        //echo htmlspecialchars($res);
        $this->format($fileModelDest, htmlspecialchars($res));

        $fileModel = $tplPath . "Model.php";
        $fileModelDest = $dstPath . "Model/" . $obj["name"] . ".php";
        $textModel = file_get_contents($fileModel);

        $data = new Data("Fields.json");
        $ids = $data->readDataFile();
        $code = '';
        $setters = '';
        $getters = '';
        foreach ($ids["data"] as $key => $value) {
            if ($value["model"] == $id) {
                //echo $value["name"];
                //$code .= "    "."/** {$value["comment"]} */\n";
                $type = $value['type'];

                if (Model::isEntity($value["type"])) {
                    //echo 'isEntity';
                    $code .= "    #[ORM\ManyToOne(targetEntity: " . $type . "::class, cascade: array('persist'))]\n";
                    $code .= "    #[ORM\JoinColumn(name: '" . strtolower($type) . "_id', referencedColumnName: 'id', options : array('comment'=>'" . $value["comment"] . "'))]\n";
                    if (strtolower(trim($value['value'])) == 'null') {
                        $type = $value["type"] . "|null";
                    }
                } else {
                    $typeSimple = Model::getDoctrineType($value["type"]);
                    $code .= "    #[ORM\Column(type: '$typeSimple', options : array('comment'=>'" . $value["comment"] . "'))]\n";
                }
                //echo " type=".$type;
                if ($value["type"] == 'string') {
                    $value["value"] = "'" . $value["value"] . "'";
                }
                //$code .= "    ".'private '.$value['type'].' $'.$value['name'].' = '.$value['value'].";\n";
                $code .= "    private {$type} $" . $value['name'] . " = {$value['value']}; \n\n";

                if ('id' != $value['name']) {
                    $setters .= $this->generateSetter($value['name']);
                    $getters .= $this->generateGetter($value['name']);
                }
            }
        }
        $code .= $setters;
        $code .= $getters;

        $res = sprintf($textModel, strtolower($obj["name"]), $obj["comment"], $obj["name"], $code);
        file_put_contents($fileModelDest, $res);
        chmod($fileModelDest, 0775);
        //echo htmlspecialchars($res);
        $this->format($fileModelDest, htmlspecialchars($res));
        //$obj = $data->getById($id);
        //IndexController::indexAction();
    }

    function generateSetter($name, $type = "set") {
        $code = '';
        $code .= "    function " . $type . ucfirst($name) . "($" . $name . "Value){ \n";
        $code .= '        $this->' . $name . ' = $' . $name . 'Value;' . "\n";
        $code .= "    }\n\n";
        return $code;
    }

    function generateGetter($name, $type = "get") {
        $code = '';
        $code .= "    function " . $type . ucfirst($name) . "(){ \n";
        $code .= '        return $this->' . $name . ";\n";
        $code .= "    }\n\n";
        return $code;
    }

    public function orm_updateAction() {
        e::o('Resutl:');
        $cmd = 'php ../bin/doctrine orm:schema-tool:update --force';
        $res = Proc::exec($cmd);
        return $res;
    }

    public function orm_sqlAction() {
        //$res = exec('pwd');
        $cmd = 'php ../bin/doctrine orm:schema-tool:update --dump-sql';
        $res = Proc::exec($cmd);
        return "SQL: " . $res;
    }

    public function getItems() {
        $html = parent::getItems();
        $modelName = $this->getModelName();
        $sql = new Button("SQL ", "Result", Url::go($modelName . "/orm_sql"), "loadText");
        $html .= $sql->getHTML();
        $sql = new Button("Update Database ", "Result", Url::go($modelName . "/orm_update"), "loadText");
        $html .= $sql->getHTML();
        return $html;
    }

    
}

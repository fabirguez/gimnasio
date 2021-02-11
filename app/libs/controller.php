<?php

class Controller
{
    public function __construct()
    {
        $this->view = new View();
    }

    //fin constructor

    public function loadModel($model)
    {
        $url = 'models/'.$model.'models.php';

        if (file_exists($url)) {
            require_once $url;

            $modelName = $model.'Model';
            $this->model = new $modelName();
        }//fin if
    }

    //fin loadmodel

    public function existPOST($params)
    {
        //si el parametro no existe, rechaza todo
        foreach ($params as $params) {
            if (!isset($_POST[$param])) {
                echo 'existPost en controller --> no existe el parametro $param';

                return false;
            }//fin if
        }//fin fore

        return true;
    }

    //fin existpost

    public function existGET($params)
    {
        //si el parametro no existe, rechaza todo
        foreach ($params as $params) {
            if (!isset($_GET[$param])) {
                echo 'existGet en controller --> no existe el parametro'.$param.' ';

                return false;
            }//fin if
        }//fin fore

        return true;
    }

    //fin existget

    public function getGet($name)
    {
        return $_GET[$name];
    }

    //fin get get

    public function getPost($name)
    {
        return $_POST[$name];
    }

    //fin get post

    public function redirect($url, $mensajes)
    {
        //cuando haya un error redirige al usuario a una página BORRARRR
        $data = [];
        $params = '';

        foreach ($mensajes as $key => $mensaje) {
            array_push($data, $key.'='.$mensaje);
        }//fin fore
        $params = join('&', $data);
        //?nombre=Fabi&Apellidos=Fabian
        if ($params != '') {
            $params = '?'.$params;
        }//fin if

        header('Location: '.constant('URL').$route.$params);
    }
}

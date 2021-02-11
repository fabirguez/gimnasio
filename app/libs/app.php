<?php

//se pone aqui y no en el index.php pq solo se llama si existen errores aquí
require_once 'controllers/errores.php';

class App
{
    public function __construct()
    {
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = explode('/', $url);

        if (empty($url[0])) {     //si el controlador no existe lo redirige a otro lado, en este caso al login
            $archivoController = 'controllers/login.php';
            require_once $archivoController;
            $controller = new Login();
            $controller->loadModel('login');
            $controller->render();

            return false;
        }//fin if

        //si se ha escrito la ruta:
        $archivoController = 'controllers/'.$url[0].'.php';

        if (file_exists($archivoController)) {
            require_once $archivoController;

            $controller = new $url[0]();
            $controller->loadModel($url[0]);

            if (isset($url[1])) {
                if (method_exists($controller, $url[1])) {
                    if (isset($url[2])) {
                        $nparam = count($url) - 2;

                        $nparam = [];

                        for ($i = 0; $i < $nparam; ++$i) {
                            array_push($params, $url[$i] + 2);
                        }//fin for
                        $controller->{$url[1]}($params);
                    } else {
                        //no tiene parametros, se manda a llmar el metodo tal cual
                        $controller->{$url[1]}();
                    }//fin else
                } else {
                    //no existe el metodo
                    $controller = new Errores();
                }
            } else {
                //no hay metodo, se carga el de por defecto
                $controller->render();
            }//fin else
        } else {
            //el archivo no existe por lo que manda un error
            $controller = new Errores();
        }
    }
}

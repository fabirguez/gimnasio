<?php

require_once '../models/usuario.php';
require_once '../DB/connectDB.php';

//Metodos por defecto para los formularios
if (isset($_POST['id'])) {
    if ($_GET['op'] == 0) {       //Eliminar
        UsuarioController::delUsuario($_POST['id']);
    }
    if ($_GET['op'] == 1) {      //Modificar
        UsuarioController::modUsuario();
    }
    if ($_GET['op'] == 2) {	   	//Crear
        UsuarioController::creUsuario();
    }
    if ($_GET['op'] == 3) {	   	//Login
        UsuarioController::login();
    }
    if ($_GET['op'] == 5) {	   	//modpefil
        UsuarioController::modPerfilUsuario();
    }
}

if (isset($_GET['op']) && $_GET['op'] == 4) {
    session_start();
    unset($_SESSION['userID']);
    header('Location: ../Views/paginaPrincipal.php'); //redirect pagina anterior
}

class UsuarioController
{
    public function __construct()
    {
    }

    public function gestionUsuarios()
    {
        $u = new Usuario();
        $usuarios = $u->getUsuarios();

        return $usuarios;
    }

    public static function delUsuario($id)
    {
        $u = new Usuario();
        $u->deleteUsuario($id);
        header('Location: '.$_SERVER['HTTP_REFERER']); //redirect pagina anterior
    }

    public static function creUsuario()
    {
        if ($_POST['passUsuario'] == $_POST['passUsuario2']) {
            $u = new Usuario();
            $u->createUsuario($_POST['nif'],$_POST['nombre'],
                          $_POST['apellidos'],$_POST['email'],
                          $_POST['password'],$_POST['telefono'],
                          $_POST['direccion'],$_POST['estado'],
                          $_POST['imagen'], $_POST['rol_id']);
            header('Location: ../Views/gestionusuarios/index.php'); //redirect pagina anterior
        } else {
            //TODO Esto manda un mensaje de error
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    }

    public static function getUsuario($id)
    {
        $u = new Usuario();

        return $u->getById($id);
    }

    //Enchufa todas las variables POST en base de datos
    public static function modUsuario()
    {
        $u = new Usuario();
        if (!isset($_POST['direccion'])) {
            $direc = '';
        } else {
            $direc = $_POST['direccion'];
        }

        if (!isset($_POST['telefono'])) {
            $telefono = '';
        } else {
            $telefono = $_POST['telefono'];
        }

        if (!isset($_POST['estado'])) {
            $estado = '';
        } else {
            $estado = $_POST['estado'];
        }

        $u->modificarUsuario($_POST['id'], $_POST['nombre'], $direc, $telefono, $estado, $_POST['rol_id']);
        header('Location: ../Views/gestionusuarios/index.php');
    }

    public static function modPerfilUsuario()
    {
        $u = new Usuario();
        if (!isset($_POST['direccion'])) {
            $direc = '';
        } else {
            $direc = $_POST['direccion'];
        }

        if (!isset($_POST['telefono'])) {
            $telf = '';
        } else {
            $telf = $_POST['telefono'];
        }

        if (!isset($_POST['imagen'])) {
            $img = '';
        } else {
            $img = $_POST['imagen'];
        }

        $u->modificarUsuarioP($_POST['id'], $direc, $telf, $img);
        header('Location: ../Views/gestionusuarios/index.php');
    }

    public function getUserByEmail($email)
    {
        $u = new Usuario();
        $result = $u->getByEmail($email);

        return $result;
    }

    public static function login()
    {
        $u = new Usuario();
        $loginCorrecto = $u->tryLogin($_POST['email'], $_POST['pass']);
        if ($loginCorrecto) {
            session_start();
            $_SESSION['userID'] = $_POST['email'];
        }
        header('Location: ../Views/home/index.php');
    }

    public static function signIn()
    {
        $u = new Usuario();
        $u->createUsuario($_POST['nif'],$_POST['nombre'],
                          $_POST['apellidos'],$_POST['email'],
                          $_POST['password'],$_POST['telefono'],
                          $_POST['direccion'], $_POST['imagen']);
        header('Location: ../Views/registro/registrado.php'); //redirect pagina anterior
    }

    public function activateUser()
    {
        //para activar el usuario comprobar
        if (isset($_POST['id'])) {
            $estado = 1;
        }
    }

    public function listado()
    {
        // Almacenamos en el array 'parametros[]'los valores que vamos a mostrar en la vista
        $parametros = [
            'tituloventana' => 'Base de Datos con PHP y PDO',
            'datos' => null,
            'mensajes' => [],
        ];
        // Realizamos la consulta y almacenamos los resultados en la variable $resultModelo
        $resultModelo = $this->modelo->listado();
        // Si la consulta se realizó correctamente transferimos los datos obtenidos
        // de la consulta del modelo ($resultModelo["datos"]) a nuestro array parámetros
        // ($parametros["datos"]), que será el que le pasaremos a la vista para visualizarlos
        if ($resultModelo['correcto']) :
          $parametros['datos'] = $resultModelo['datos'];
        //Definimos el mensaje para el alert de la vista de que todo fue correctamente
        $this->mensajes[] = [
              'tipo' => 'success',
              'mensaje' => 'El listado se realizó correctamente',
          ]; else :
          //Definimos el mensaje para el alert de la vista de que se produjeron errores al realizar el listado
          $this->mensajes[] = [
              'tipo' => 'danger',
              'mensaje' => "El listado no pudo realizarse correctamente!! :( <br/>({$resultModelo['error']})",
          ];
        endif;
        //Asignamos al campo 'mensajes' del array de parámetros el valor del atributo
        //'mensaje', que recoge cómo finalizó la operación:
        $parametros['mensajes'] = $this->mensajes;
        // Incluimos la vista en la que visualizaremos los datos o un mensaje de error
        include_once 'vistas/listado.php';
    }

    // public function getDeportistas()
    // {
    //     $u = new Usuario();

    //     return $u->findByType('deportista');
    // }
}

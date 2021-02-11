<?php

require_once 'libs/database.php';
// require_once 'libs/messages.php';
require_once 'classes/errors.php';
require_once 'classes/success.php';
require_once 'libs/controller.php';
require_once 'libs/view.php';
require_once 'libs/model.php';
require_once 'libs/app.php';

  $app = new App();

/*
 * Script que se encarga de redirigir las rutas de los enlaces pulsado en la
 * vista del listado. A él deberá llegar el nombre de la acción y, si fuese
 * necesario, el id del usuario sobre el que se va a realizar dicha acción.
 * Lo hacemos así para poder llamar directamente a los métodos del controlador,
 * de lo contrario tendríamos que especificar los controladores en ficheros
 * diferentes
 */

// phpinfo();

/* require_once 'controllers/controlador.php';
//Definimos un objeto controlador
$controlador = new controlador();

if ($_GET && $_GET["accion"]) :
  //Sanitizamos los datos que recibamos mediante el GET
  $accion = filter_input(INPUT_GET, "accion", FILTER_SANITIZE_STRING);
  //Verificamos que el objeto controlador que hemos creado implementa el
  //método que le hemos pasado mediante GET
  if (method_exists($controlador, $accion)) :
      $controlador->$accion(); //Ejecutamos la operación indicada en $accion
  else :
      $controlador->index();   //Redirigimos a la página de inicio
  endif;

else :
  $controlador->index();
endif;

 */

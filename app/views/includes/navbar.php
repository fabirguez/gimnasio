
<!--ESTO DA UN ERROR MUY RANDOM SI NO ESTA AQUI EN LUGAR DE ABAJO-->
<?php if (!isset($_SESSION)) {
    session_start();
}?>

<!--Este script contiene las funciones referentes a la comprobación de formularios-->
<script>
// <?php //include '../js/FormCheck.js';?>
</script>
<!--HASTA AQUI-->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
<?php
// require_once '../controllers/c_Notificaciones.php';
require_once '../controllers/usuario.php';
//VAMOS A HACER UN SET DE CREDENCIALES
// EL MAXIMO ES 2 y minimo 0
//0 - Admin
//1 - Usuario
//2 - Unregistered

$logged = false;
$permit = 2; //unregistered
if (isset($_SESSION['userID'])) {
    $logged = true;
    $userController = new UsuarioController();
    $tipoUser = $userController->getUserByEmail($_SESSION['userID'])['tipoUsuario'];
    if ($tipoUser == '1') { //usuario
        $permit = 1;
    }
    if ($tipoUser == '0') { //admin
        $permit = 0;
    }
}
?>

<link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
<nav class="navbar navbar-default">
  <div class="container-fluid">
  <div class= "collapse navbar-collapse">
    <ul class="nav navbar-nav">
      <li><a href="paginaPrincipal.php">Inicio</a></li>
      <!--Este dropdown solo se ve si tienes permisos de admin o entrenador-->
      <?php if ($permit < 2) { ?>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Gestión <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <?php if ($permit == 0) { ?>
          <li><a href="GestionEjercicios.php">Gestión de Ejercicios</a></li>
          <li><a href="GestionActividades.php">Gestión de Actividades</a></li>
          <?php } ?>
          <li><a href="GestionUsuarios.php">Gestión de Usuarios</a></li>
          <li><a href="GestionTablas.php">Gestión de Tablas</a></li>
        </ul>
      </li>
      <!--HASTA AQUI -->
      <?php } ?>
      <li><a href="ListaActividades.php">Lista de Actividades</a></li>
      <?php if ($permit == 1) { ?>
      <li><a href="MisActividadesReservadas.php">Mis reservas</a></li>
      <li><a href="ListaTablas.php">Entrenamiento</a></li>
      <li><a href="MisEstadisticas.php">Mis estadisticas</a></li>
      <?php } ?>

      <?php
      if ($logged) {
          $userController = new UsuarioController();
          $user = $userController->getUserByEmail($_SESSION['userID']);
          $notificacionesController = new NotificacionesController();
          $notificaciones = $notificacionesController->getNotificaciones($user['idUsuario']);
          $dibujadas = []; ?>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Notificaciones (<?php if (count($notificaciones) > 1) {
              echo count($notificaciones) - 1;
          } else {
              echo count($notificaciones);
          } ?>) <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <?php
            foreach ($notificaciones as $n) {
                if (!in_array($n['contenido'], $dibujadas)) {
                    array_push($dibujadas, $n['contenido']); //Consideramos añadir TRUE como tercer parametro si esto falla
          ?>
            <li>
              <div class="tabla text-center"><?php echo $n['contenido']; ?></div>
            </li>

          <?php
                }//Cierre de if
            } //cierre de foreach
            if (count($notificaciones) > 0) {
                ?>

            <form method="post" action="../Controllers/c_Notificaciones.php?op=1">
              <input class="btn btn-info" type="submit" value="Borrar Notificaciones"/>
            </form>
          <?php
            } //Cierre de if
          ?>
          </ul>
        </li>
      <?php
      } //cierre de if
      ?>

      <li><?php if ($logged) {
          echo '<a href=../Views/PerfilUsuarios.php>'.$_SESSION['userID'].'</a>';
      } else {
          echo '<a>anonimo</a>';
      }?></li>
      <?php if ($logged) { ?>
      <li><a href="../Controllers/c_Usuario.php?op=4"> salir</a></li>
      <?php } else { ?>
      <li><a href="LogIn.php">login</a></li>
      <?php } ?>
    </ul>
    </nav>
  </div>
</div>

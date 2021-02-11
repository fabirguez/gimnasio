<?php

/*
Aquí se guardan todos los mensajes de error que puedan aparecer en el proyecto,
como un fallo autenticandose o cambiando una foto, por ejemplo
*/
class ErrorMessages
{
    //const ERROR_CONTROLADOR_METODO_ACCION = "435yv4y34tv4wt4 (un codigo aleatorio), se usa un codificador md5 "
    const ERROR_PRUEBA = '2121';
    private $errorList = [];

    public function __construct()
    {
        $this->errorList = [
            ErrorMessages::ERROR_PRUEBA => 'Error de prueba',
        ];
    }

    //fin constructor

    public function get($hash)
    {
        return $this->errorList[$hash];
    }

    public function existKey($key)
    {
        if (array_key_exists($key, $this->errorList)) {
            return true;
        } else {
            return false;
        }//fin ifelse
    }

    //fin existe clave
}

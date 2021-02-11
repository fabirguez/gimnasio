<?php

/*
Aquí se guardan todos los mensajes de ok que puedan aparecer en el proyecto,
como una correcta autenticacion o cambiando una foto, por ejemplo
*/
class SuccessMessages
{
    //const SUCCESS_CONTROLADOR_METODO_ACCION = "435yv4y34tv4wt4 (un codigo aleatorio), se usa un codificador md5 "
    const SUCCESS_PRUEBA = '1212';
    private $successList = [];

    public function __construct()
    {
        $this->successList = [
            SuccessMessages::SUCCESS_PRUEBA => 'Correcto! de prueba',
        ];
    }

    //fin constructor

    public function get($hash)
    {
        return $this->successList[$hash];
    }

    public function existKey($key)
    {
        if (array_key_exists($key, $this->successList)) {
            return true;
        } else {
            return false;
        }//fin ifelse
    }

    //fin existe clave
}

<?php

class View
{
    public function __construct()
    {
    }

    public function render($nombre, $data = [])
    {
        $this->d = $data;

        $this->handleMessages();

        require 'views/'.$nombre.'.php';
    }

    //fin render

    private function handleMessages()
    {
        if (isset($_GET['success']) && isset($_GET['error'])) {
            //error, no es posible que exista error y correcto a la vez
        } elseif (isset($_GET['success'])) {
            $this->handleSuccess();
        } elseif (isset($_GET['error'])) {
            $this->handleError();
        }//fin else if
    }

    //fin handle messages

    private function handleError()
    {
        $hash = $_GET['error'];
        $errors = new ErrorMessages();

        if ($errors->existKey($hash)) {
            $this->d['error'] = $errors->get($hash);
        }//fin if
    }

    //fin handle error

    private function handleSuccess()
    {
        $hash = $_GET['success'];
        $success = new SuccessMessages();

        if ($success->existKey($hash)) {
            $this->d['success'] = $success->get($hash);
        }//fin if
    }

    //fin handle success

    public function showMessages()
    {
        $this->showErrors();
        $this->showSuccess();
    }

    //fin show mensajes

    public function showErrors()
    {
        if (array_key_exists('error', $this->d)) {
            echo '<div class="error">'.$this->d['error'].'</div>';
        }//fin if
    }

    //fin enseña error

    public function showSuccess()
    {
        if (array_key_exists('success', $this->d)) {
            echo '<div class="success">'.$this->d['success'].'</div>';
        }//fin if
    }

    //fin enseña correcto
}

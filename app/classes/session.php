<?php

class Session
{
    private $sessionName = 'user';

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }//fin if
    }

    //fin constructor

    public function setCurrentUser($user)
    {
        $_SESSION[$this->sessionName] = $user;
    }

    //fin set current user

    public function getCurrentUser()
    {
        return $_SESSION[$this->sessionName];
    }

    //fin get current user

    public function closeSession()
    {
        session_unset();
        session_destroy();
    }

    //fin cierra sesion

    public function exists()
    {
        return isset($_SESSION[$this->sessionName]);
    }

    //fin exists
}

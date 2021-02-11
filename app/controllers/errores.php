<?php

class Errores extends Controller
{
    public function __construct()
    {
        parent::__construct();
        // echo 'inicio errores';
        $this->view->render('errores/index');
    }

    public function render()
    {
        // $this->view->render('errores/index');
    }
}

<?php

interface IModel
{
    //Estas funciones son las que se usarán en los cruds
    public function save();

    public function getAll();

    public function get($id);

    public function delete($id);

    public function update();

    public function from($array);
}

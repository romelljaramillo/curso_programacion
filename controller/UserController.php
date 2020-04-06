<?php

class UserController {

    public $nombre;
    public $apellido;
    public $edad;
    public $sexo;
    private $ruta = 'model/';

    public function __construct($nombre, $apellido, $edad, $sexo) {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->edad = $edad;
        $this->sexo = $sexo;
    }

    private function sacarEdad($edad) {
        $this->edad = $edad;
    }

    public function ingresarEdad($edad)
    {
        return $this->sacarEdad($edad);
    }

    public function createDirBackup($name_dir)
    {
        if (!file_exists($this->ruta . $name_dir)){
            $dir = $this->ruta . $name_dir;
        }

        mkdir($dir, 7777);
    }

}



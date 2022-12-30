<?php
namespace Model;
use Model\ActiveRecord;

class Categoria extends ActiveRecord{
    protected static $tabla = 'categorias';
    protected static $columnasDB = ['id', 'nombre'];

    public $id;
    public $nombre;
}
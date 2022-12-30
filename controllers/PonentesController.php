<?php

namespace Controllers;

use Classes\paginacion;
use Intervention\Image\ImageManagerStatic as Image;
use Model\Ponente;
use MVC\Router;

class PonentesController {
    public static function index(Router $router){
        if(!is_admin()) {
            header('Location:  /login');
        }

        $pagina_actual = $_GET['page'];
        $pagina_actual = \filter_var($pagina_actual, FILTER_VALIDATE_INT);
        
        if(!$pagina_actual || $pagina_actual < 1 ) {
            header('Location: /admin/ponentes?page=1');
        }

        $registros_por_pagina = 5;
        $total = Ponente::total();
        $paginacion = new paginacion($pagina_actual,$registros_por_pagina,$total);
        

        $ponentes = Ponente::paginar($registros_por_pagina,$paginacion->offset());

        if($paginacion->total_paginas() < $pagina_actual) {
            header('Location:  /admin/ponentes?page=1');
        }
        
        

        $router->render('admin/ponentes/index', [
            'titulo' => 'Ponentes / Conferencistas',
            'ponentes' => $ponentes,
            'paginacion' => $paginacion->paginacion()
        ]);
    }

    public static function crear(Router $router){

        if(!is_admin()) {
            header('Location:  /login');
        }

        $alertas = [];
        $ponente = new Ponente;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!is_admin()) {
                header('Location:  /login');
            }

            // Leer Imagen
            if(!empty($_FILES['imagen']['tmp_name'])) {
                $carpetaImagenes = '../public/img/speakers';

                // Crear la carpeta si no existe

                if(!is_dir($carpetaImagenes)) {
                    mkdir($carpetaImagenes,0755,true);
                }

                $imagen_png = Image::make($_FILES['imagen']['tmp_name']) -> fit(800,800) -> encode('png',80);
                $imagen_webp = Image::make($_FILES['imagen']['tmp_name']) -> fit(800,800) -> encode('webp',80);

                $nombre_imagen = md5(uniqid(rand(), true));

                $_POST['imagen'] = $nombre_imagen;
            }

            $_POST['redes'] =  json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);

            $ponente->sincronizar($_POST);
 
            // Validar
            $alertas = $ponente->validar();


            // Guardar Registro
            if(empty($alertas)) {
                // Gardar las imagenes
                $imagen_png->save($carpetaImagenes . '/' . $nombre_imagen . '.png');
                $imagen_webp->save($carpetaImagenes . '/' . $nombre_imagen . '.webp');
 
                // Guardar registro en la base de datos
                $resultado = $ponente->guardar();

                if($resultado) {
                    header('Location: /admin/ponentes');
                }
            }
      }

        $router->render('admin/ponentes/crear', [
            'titulo' => 'Registrar Ponente',
            'alertas' => $alertas,
            'ponente' => $ponente,
            'redes' => json_decode($ponente->redes)
        ]);
    }

    public static function editar(Router $router) {

        if(!is_admin()) {
            header('Location:  /login');
        }

        $alertas = [];
        
        //Validar el id
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if(!$id) {
            header('Location: /admin/ponentes');
        }

        // Obtener ponente a editar
        $ponente = Ponente::find($id);

        if(!$ponente) {
            header('Location: /admin/ponentes');
        }

        $ponente->imagen_actual = $ponente->imagen;
        $redes = json_decode($ponente->redes);

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(!is_admin()) {
                header('Location:  /login');
            }

             // Leer Imagen
            if(!empty($_FILES['imagen']['tmp_name'])) {
                $carpetaImagenes = '../public/img/speakers';

                // Crear la carpeta si no existe

                if(!is_dir($carpetaImagenes)) {
                    mkdir($carpetaImagenes,0755,true);
                }

                $imagen_png = Image::make($_FILES['imagen']['tmp_name']) -> fit(800,800) -> encode('png',80);
                $imagen_webp = Image::make($_FILES['imagen']['tmp_name']) -> fit(800,800) -> encode('webp',80);

                $nombre_imagen = md5(uniqid(rand(), true));

                $_POST['imagen'] = $nombre_imagen;
            } else {
                $_POST['imagen'] = $ponente->imagen_actual;
            }

            $_POST['redes'] =  json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);
            $ponente->sincronizar($_POST);

            $alertas = $ponente->validar();

            if(empty($alertas)) {
                if(isset($nombre_imagen)) {
                    // Gardar las imagenes
                    $imagen_png->save($carpetaImagenes . '/' . $nombre_imagen . '.png');
                    $imagen_webp->save($carpetaImagenes . '/' . $nombre_imagen . '.webp');
 
                }

                $resultado = $ponente->guardar();

                if($resultado) {
                    header('Location: /admin/ponentes');
                }
            }
        }

        $router->render('admin/ponentes/editar', [
            'titulo' => 'Actualizar Ponente',
            'alertas' => $alertas,
            'ponente' =>  $ponente,
            'redes' => $redes
        ]);

    }

    public static function eliminar(){

        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
                header('Location:  /login');
            }

            $id = $_POST['id'];

            $ponente = Ponente::find($id);

            if(!isset($ponente)) {
                header('Location: /admin/ponentes');
            }
            
            $resultado = $ponente->eliminar();
            

            if($resultado) {
                header('Location: /admin/ponentes');
            }

        }

        
    }
}
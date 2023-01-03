<?php

namespace Controllers;

use Model\Paquete;
use Model\Registro;
use Model\Usuario;
use MVC\Router;

class RegistroController {

    public static function crear(Router $router) {

        if(!is_auth()) {
            header('Location: /');
        }

        // Verificar si el usuario ya esta registrado
        $registro = Registro::where('usuario_id',$_SESSION['id']);
        if(isset($registro) && $registro->paquete_id === "3") {
            header('Location: /boleto?id='. urlencode($registro->token));
        }

        $router ->render('registro/crear', [
            'titulo' => 'Finalizar Registro'
        ]);
    }

    public static function gratis() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_auth()) {
                header('Location: /login');
            }

            // Verificar si el usuario ya esta registrado
            $registro = Registro::where('usuario_id',$_SESSION['id']);
            if(isset($registro) && $registro->paquete_id === "3") {
            header('Location: /boleto?id='. urlencode($registro->token));
            }
            
            $token = substr(md5(uniqid(rand(), true)), 0, 8);
            
            // Crear Registro
            $datos = array(
                'paquete_id' => 3,
                'pago_id' => '',
                'token' => $token,
                'usuario_id' => $_SESSION['id']
            );

            $registro = new Registro($datos);
            $resultado = $registro->guardar();

            if($resultado) {
                header('Location: /boleto?id='. urlencode($registro->token));
            }
        }
    }

    public static function boleto(Router $router) {

        // Validar la url
        $id = $_GET['id'];

        if(!$id || strlen($id) !== 8) {
            header('Location: /');
        }

        // Buscar en la BD
        $registro = Registro::where('token',$id);
        if(!$registro) {
            header('Location: /');
        }

        // Llenar las tablas de referencia
        $registro->usuario = Usuario::find($registro->usuario_id);
        $registro->paquete = Paquete::find($registro->paquete_id);
        

        $router ->render('registro/boleto', [
            'titulo' => 'Asisencia a DevWebCamp',
            'registro' => $registro
        ]);
    }
} 
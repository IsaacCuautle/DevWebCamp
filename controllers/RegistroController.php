<?php

namespace Controllers;

use Model\Categoria;
use Model\Dia;
use Model\Eventos;
use Model\Hora;
use Model\Paquete;
use Model\Ponente;
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

    public static function pagar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_auth()) {
                header('Location: /login');
            }

            // Validar que POST no venga vacio
            if(empty($_POST)) {
                echo json_encode([]);
                return;
            }
            
            // Crear Registro
            $datos = $_POST;
            $datos['token'] = substr(md5(uniqid(rand(), true)), 0, 8);
            $datos['usuario_id'] = $_SESSION['id'];
           
            

            try {
                $registro = new Registro($datos);
                $resultado = $registro->guardar();
                echo json_encode($resultado);

            } catch (Throwable $th) {

                echo json_encode([
                    'resultado' => 'error'
                ]);
            }
        }
    }

    public static function conferencias(Router $router) {
        if (!is_auth()) {
            header('Location: /login');
        }
        
        // Validar que el usuario tenga el plan presencial
        $usuario_id = $_SESSION['id'];
        $registro = Registro::where('usuario_id', $usuario_id);
        
        if($registro->paquete_id !== '1') {
            header('Location: /');
        }
        
        $eventos = Eventos::ordenar('hora_id','asc');
        $eventosFormateados = [];
        foreach ($eventos as $evento) {
            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia = Dia::find($evento->dia_id);
            $evento->hora = Hora::find($evento->hora_id);
            $evento->ponente = Ponente::find($evento->ponente_id);
            
            if($evento->dia_id === '1' && $evento->categoria_id === '1') {
                $eventosFormateados['conferencias_V'][] = $evento;
            }
            if($evento->dia_id === '2' && $evento->categoria_id === '1') {
                $eventosFormateados['conferencias_S'][] = $evento;
            }
            if($evento->dia_id === '1' && $evento->categoria_id === '2') {
                $eventosFormateados['workshops_V'][] = $evento;
            }
            if($evento->dia_id === '2' && $evento->categoria_id === '2') {
                $eventosFormateados['workshops_S'][] = $evento;
            }
        }


        $router ->render('registro/conferencias', [
            'titulo' => 'Elige Workshops y Conferencias',
            'eventos' => $eventosFormateados
        ]);
    }
} 
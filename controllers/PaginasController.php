<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController {
    public static function index( Router $router){
        $propiedades = Propiedad::get(3);
        $inicio = true;
       $router-> render('paginas/index',[
        'propiedades' => $propiedades ,
        'inicio' => $inicio

       ]);
    }
    public static function nosotros(Router $router){
       $router-> render('paginas/nosotros');
    }
    public static function propiedades(Router $router){
        $propiedades = Propiedad::all();

        $router -> render('paginas/propiedades', [
            'propiedades' => $propiedades
        ]);
    }
    public static function propiedad(Router $router){
       $id = validarORedireccionar('/propiedades');

       $propiedad = Propiedad::find($id);
        $router -> render('paginas/propiedades', [
            'propiedad' => $propiedad
            
        ]);
    }
    public static function blog(Router $router){
        $router -> render('paginas/blog');
    }
    public static function entrada(Router $router){
        $router -> render('paginas/entrada');

    }
    public static function contacto(Router $router){
        if($_SERVER['REQUEST_METHOD']=== 'POST'){
            $respuestas = $_POST['contacto'];

            $mail = new PHPMailer();

            $mail -> isSMTP();
            $mail -> Host = 'smtp.mailtrap.io';
            $mail -> SMTPAuth = true;
            $mail -> Username ='80ff6bb2ef6363';
            $mail -> Password = '5f5ccf790a9a40';
            $mail -> SMTPSecure = 'tls';
            $mail ->Port = 2525;

            $mail -> setFrom('admin@bienes.com');
            $mail-> addAddress('admin@bienes.com', 'Bienesraices.com');
            $mail-> Subject = 'Tienes un nuevo mensaje';
            
            $mail-> isHTML(true);
            $mail-> CharSet = 'UTF-8';

            $contenido = '<html>';
            $contenido .= '<p>Tienes un nuevo mensaje</p>';
            $contenido .= '<p>Nombre: ' .$respuestas['nombre'] . '</p>';
            if($respuestas['contacto']=== 'telefono') {
                $contenido = '<p>Eligio ser contactado por Telefono:</p>';
                $contenido .= '<p>Telefono: ' .$respuestas['telefono'] . '</p>';
                $contenido .= '<p>Fecha contacto: ' .$respuestas['fecha'] . '</p>';
                $contenido .= '<p>Hora: ' .$respuestas['hora'] . '</p>';
            } else {
                $contenido = '<p>Eligio ser contactado por email:</p>';
                $contenido .= '<p>email: ' .$respuestas['email'] . '</p>';
            }
           

            $contenido .= '<p>Mensaje: ' .$respuestas['mensaje'] . '</p>';
            $contenido .= '<p>Vende o compra: ' .$respuestas['tipo'] . '</p>';
            $contenido .= '<p>Presupuesto: $' .$respuestas['precio'] . '</p>';
            $contenido .= '<p>Prefiere ser contactado por: ' .$respuestas['contacto'] . '</p>';
            $contenido .= '</html>';
            $mail -> Body = $contenido;
            $mail -> AltBody = 'Esto es un texto ';


            if($mail -> send()){
                $mensaje = "Mensaje enviado";
            } else {
                $mensaje= "No se pudo enviar el mensaje";
            }
        };



        $router-> render('paginas/contacto',[
            'mensaje' => $mensaje
        ]);
    }
}
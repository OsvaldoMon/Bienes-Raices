<?php

namespace Controllers;

use Model\Vendedor;
use MVC\Router;

class VendedorController{
    public static function crear(Router $router){

      $errores = Vendedor::getErrores();
      $vendedor = new Vendedor;

      // Ejecutar el código después de que el usuario envia el formulario
      if($_SERVER['REQUEST_METHOD'] === 'POST') {

          /** Crea una nueva instancia */
          $vendedor = new Vendedor($_POST['vendedor']);

          // Validar
          $errores = $vendedor->validar();


          if(empty($errores)) {

              // Guarda en la base de datos
              $resultado = $vendedor->guardar();

              if($resultado) {
                  header('location: /vendedores');
              }
          }
      }

      $router->render('vendedores/crear', [
          'errores' => $errores,
          'vendedor' => $vendedor
      ]);
        
    }
    public static function actualizar(Router $router){
      $id = validarORedireccionar('/admin');

      // Obtener los datos de la propiedad
      $vendedor = Vendedor::find($id);

      // Arreglo con mensajes de errores
      $errores = Vendedor::getErrores();

      
      if($_SERVER['REQUEST_METHOD'] === 'POST') {

              // Asignar los atributos
              $args = $_POST['vendedor'];
              $vendedor->sincronizar($args);

              // Validación
              $errores = $vendedor->validar();
              
              if(empty($errores)) {

                  // Guarda en la base de datos
                  $resultado = $vendedor->guardar();

                  if($resultado) {
                      header('location: /admin');
                  }
              }
      }

      $router->render('vendedores/actualizar', [
          'vendedor' => $vendedor,
          'errores' => $errores
      ]);
  }
    public static function eliminar(){
      if($_SERVER['REQUEST_METHOD']=== 'POST'){
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if($id) {
          $tipo= $_POST['tipo'];
        }

        if(validarTipoContenido($tipo)){
          $vendedor = Vendedor::find($id);
          $vendedor->eliminar();
        }
      }
        
    }
}
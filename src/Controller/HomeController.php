<?php
//Creado desle la linea de comandos:cambiarse a la carpeta del proyecto y ejecutar  
//php bin/console make:controller HomeController
//Se crea automáticamente también el template: templates/home/index.html.twig

//Accesible desde: http://www.aprendiendo-symfony.com/home


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    //OJO: Esto de abajo no es un comentario, es una ruta
    
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'mensaje'=>'Hola Mundo con Symfony 4'
        ]);
    }
    
    //Las rutas se pueden crear con anotaciones como hay encima del index, o a traves
    //del fichero config/routes.yaml. La de animales está en config/routes.yaml
    public function animales($nombre,$apellidos){
        $titulo ='Bienvenido a la página de animales';
        return $this->render('home/animales.html.twig',['titulo'=>$titulo,
            'nombre'=>$nombre,
            'apellidos'=>$apellidos
                ]);
    }
    
    public function redirigir(){
        // $this es el objeto del controlador
        //redirige por nombre de ruta index, de tipo 301
        //return $this->redirectToRoute('index',array(),301); 
        
        //Se pueden redirigir con parámetros. Hay que borrar caché de symfony
        //para que funcione inmediatamente en var/cache, e ir a una pestaña
        //privada del navegador
//        return $this->redirectToRoute('animales',[
//            'nombre'=>'Juan Pedro',
//            'apellidos'=>'Lopez'
//        ]); 
        
        return $this->redirect('http://www.marca.es');

        
    }
}

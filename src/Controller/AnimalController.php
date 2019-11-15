<?php

// Creada desde terminal con : php bin/console make:controller AnimalController
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response; //Para poder devolver respuestas http
use App\Entity\Animal; //Para poder trabajar en la BD con la entidad Animal
use App\Entity\Usuario; //Para poder trabajar en la BD con la entidad Usuario

class AnimalController extends AbstractController
{
//Se crea una ruta para esta acción del  controlador en config/routes.yaml
    public function index()
    {
         //Cargar repositorio para hacer consultas
        $animal_repo = $this->getDoctrine()->getRepository(Animal::class);
        
        //Hacer consulta para sacar TODOS LOS ANIMALES DE LA BASE DE DATOS
        $animales = $animal_repo->findAll();
        
        
        //Hacer consulta para sacar 1 animal con la condición especificada. El 1º encontrado
        $UnanimalCondicion = $animal_repo->findOneBy([
                'tipo'=>'koala'
                ]);
                 
                var_dump($UnanimalCondicion);
                
                
        //Hacer consulta para sacar TODOS los animales con la condición especificada
                //Se ordena descendente con id=>DESC
        $MuchosanimalCondicion = $animal_repo->findBy([
                'raza'=>'africana'
                ],['id'=>'DESC']);
        
                var_dump($MuchosanimalCondicion);
                
              
                
//OTRA ALTERNATIVA: EN SYMFONY TAMBIEN EXISTE EL QUERY BUILDER, además de DOCTRINE
//Permite hacer consultas a la base de datos más complejas
//                $qb =$animal_repo->createQueryBuilder('a')
//                                 ->andWhere("a.raza = 'africana'")
//                                 ->getQuery();
        echo "<br><br><br>USANDO QUERY BUILDER<hr>";        
        $qb =$animal_repo->createQueryBuilder('a')
                //->andWhere("a.raza = :racita")
                //->setParameter('racita','africana')
                ->orderBy('a.id','DESC')
                ->getQuery();

        $resulset = $qb->execute();

        var_dump($resulset);
                
        echo "<br><br><br>USANDO PSEUDOLENGUALE DQL<hr>";
        
// Y OTRA ALTERNATIVA: EN SYMFONY TAMBIEN EXISTE UN LENGUAJE LLAMADO DQL.
//es un pseudolenguaje de Sql llamado Doctine Query Languaje (DQL)
        $em = $this->getDoctrine()->getManager();
        $dql ="SELECT a FROM App\Entity\Animal a WHERE a.raza = 'africana'";
        //$dql ="SELECT a FROM App\Entity\Animal a ORDER BY a.id DESC";

        $query =$em->createQuery($dql);
        $resulset = $query->execute();
        
        var_dump($resulset);
        
        echo "<br><br><br>USANDO CONSULTAS SQL DIRECTAS <hr>";        
        
// Y OTRA ALTERNATIVA: EN SYMFONY TAMBIEN EXISTE CONSULTAS DIRECTAS SQL
        $conexion = $this->getDoctrine()->getConnection();
        $sql ="SELECT * FROM animales ORDER BY id DESC";
        $preparacion = $conexion->prepare($sql);

        $preparacion->execute();
        //$resulset = $preparacion->fetch(); //solo saca el primero
        $resulset = $preparacion->fetchAll();

        
        var_dump($resulset);
        
        echo "<br><br><br>USANDO REPOSITORIOS PERSONALIZADOS <hr>";   
        
//OTRA ALTERNATIVA. Uso de REPOSITORIOS PERSONALIZADOS
//IMPORTANTE. Hay que vincular la Entidad Animal (su clase) al REPOSITORIO PERSONALIZADO
//para ello ir a  src/Entity/Animal.php y atualizar la linea @ORM\Entity
//a @ORM\Entity(repositoryClass="App\Repository\AnimalRepository")
        $animals = $animal_repo->getAnimalOrderId('DESC');
        var_dump($animals);
        
        //El array animales queda disponible en la vista
        return $this->render('animal/index.html.twig', [
            'controller_name' => 'AnimalController',
            'animales' => $animales
        ]);
    }
    
    //Desde TERMINAL, se pueden hacer consultas a la base de datos con:
    // php bin/console doctrine:query:sql "SELECT * FROM animales"
    
    //Guardar en la BD en la tabla animales
    //Se crea una ruta para esta acción del  controlador en config/routes.yaml
    public function save()
    {
        //Se carga en entity manager
        $entityManager  = $this->getDoctrine()->getManager();
        
        //Se crea un objeto animal y le damos valores
        $animal =new Animal();
        $animal->setTipo('avestruz');
        $animal->setColor('verde');
        $animal->setRaza('africana');
        $animal->setDescripcion('la más grande de Africa');
        
        //guardar objeto en doctrine en una memoria propia del ORM doctrine
        $entityManager->persist($animal);
        
        //Volcar datos en la tabla en la base de datos física
        $entityManager->flush();
        
        return new Response('El animal guardado tiene de id: '.$animal->getId());
                
        //echo "<h1>Hola Mundo con ECHO</h1>";
        //return new Response('¡¡¡hola mundico con RESPONSE!!!'); //respuesta http al navegador
        
    }
    
    //Si da un error de caché, ir a la carpeta PROYECTO/var/cache y la borro
    //El id se pasa por la URL con get
    //Se crea una ruta para esta acción del  controlador en config/routes.yaml
    public function animal($id)
    {
        //Cargar repositorio para hacer consultas
        $animal_repo = $this->getDoctrine()->getRepository(Animal::class);
        
        //Hacer consulta
        $animal = $animal_repo->find($id);
        
        //Comprobar si el resultado es correcto
        if (!$animal)
            $mensaje = 'El animal no existe';
        else
            $mensaje ="Tu animal elegido es: ".$animal->getTipo().'-'.$animal->getRaza();
        
        return new Response($mensaje);

    }
    
        //El id se pasa por la URL con get
    //Se crea una ruta para esta acción del  controlador en config/routes.yaml
    //Si especificamos que el id pasado por GET es de tipo Animal, symfony interpreta
    //que hay que buscarlo en la base de datos automáticamente y rellena todos los
    //demás campos del registro cuyo id es pasado por get
    // la llamada sería http://www.aprendiendo-symfony.com/animal2/4
    public function animal2(Animal $animal)
    {
//        //Cargar repositorio para hacer consultas
//        $animal_repo = $this->getDoctrine()->getRepository(Animal::class);
//        
//        //Hacer consulta
//        $animal = $animal_repo->find($id);
//        
        //Comprobar si el resultado es correcto
        if (!$animal)
            $mensaje = 'El animal no existe';
        else
            $mensaje ="Tu animal elegido es: ".$animal->getTipo().'-'.$animal->getRaza();
        
        return new Response($mensaje);

    }
    
    //actualiza un animal de la base de datos
    public function update($id)
    {
        //Cargar doctrine
        $doctri =$this->getDoctrine();
        
        //Cargar entityManager
        $em =$doctri->getManager();
        
        //Cargar repo Animal
        $animal_repo =$em->getRepository(Animal::class);
        
        //find para conseguir el objeto
        $animal = $animal_repo->find($id);
        
        //Comprobar si el objeto me llega
        if (!$animal){
            $mensaje ='El animal no existe en la base de datos';
        }
        else{
                    
            //Asignarle los valores al objeto
            $animal->setTipo("Perro $id");//dobles comillas para que funcione $id
            $animal->setColor('rojo');
        
            //persistir en doctrine
            $em->persist($animal); //aquí no estrictamente necesario
        
            //Guardar en la base de datos
            $em->flush();
            $mensaje = 'Has actualizado el animal '.$animal->getId();
            
        }
              
        //Respuesta
        return new Response($mensaje);
    }
    
    //Borra un objeto de la base de datos, pasado como parámetro
    //Si especificamos que el id pasado por GET es de tipo Animal, symfony interpreta
    //que hay que buscarlo en la base de datos automáticamente y rellena todos los
    //demás campos del registro cuyo id es pasado por get
    // la llamada sería http://www.aprendiendo-symfony.com/delete/4
    public function delete(Animal $animal){
       //var_dump($animal);
        $em =$this->getDoctrine()->getManager();
        
        //Si el id del animal a borrar existe, $animal estará instanciado
        if ($animal && is_object($animal))
        {
            //Se quita de la memoria ORM de doctrine, no de la base de datos física
            $em->remove($animal);

            //Borra el objeto de la base de datos física
            $em->flush();
            $mensaje="Animal eliminado de la base de datos";
        }
        else    $mensaje ='animal no encontrado';
        
        
        return new Response($mensaje);
        
    }
}

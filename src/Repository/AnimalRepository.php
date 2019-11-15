<?php
//Creada desde cero. Esto es un repositorio, es decir objetos repositorio

namespace App\Repository;

use App\Entity\Animal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class AnimalRepository extends ServiceEntityRepository{
    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry,Animal::class);
    }
    
    public function getAnimalOrderId($order){
        $qb =$this->createQueryBuilder('a')
                //->andWhere("a.raza = :racita")
                //->setParameter('racita','africana')
                ->orderBy('a.id',$order)
                ->getQuery();

        $resulset = $qb->execute();
        //o devuelve el resulset o cualquier cosa que queramos, como 
        //el siguiente array personalizado (coleccion)
        $coleccion = array(
            'nombre' => 'colección de animales',
            'animales' => $resulset
        );
        return $coleccion;
    }
}
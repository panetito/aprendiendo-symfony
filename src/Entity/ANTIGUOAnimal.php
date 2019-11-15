<?php

namespace App\Entity;

//Generado en el terminal con: 
//php bin/console doctrine:mapping:import App\\Entity annotation --path=src/Entity
//Existía previamente en la base de datos MYSQL (ver fichero .env).

// Los getter y setter con: 
// php bin/console make:entity --regenerate App\\Entity\\Animales

// Se ha cambiado el nombre del archivo a Animal.php (era Animales.php)
// Y de la clase a Animal, ya que cada objeto de esta clase almacena 1 solo animal

// Se añade un nuevo campo descripcion, y para reflejarlo en la base de datos, habrá que generarç
//una migración con: php bin/console doctrine:migrations:diff, que creará un archivo en
// src/Migrations. Para ejecutar la migración y reflejarla en la base de datos habrá
// que ejecutar el comando: php bin/console doctrine:migrations:migrate

use Doctrine\ORM\Mapping as ORM;

class AnimalAntiguo
{
    private $id;

    private $tipo;

    private $color;

    private $raza;
    
    private $descripcion;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getRaza(): ?string
    {
        return $this->raza;
    }

    public function setRaza(string $raza): self
    {
        $this->raza = $raza;

        return $this;
    }
    
    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }
    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }



}

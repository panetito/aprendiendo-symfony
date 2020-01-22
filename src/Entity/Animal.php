<?php

namespace App\Entity;

// Se ha cambiado el nombre del archivo a Animal.php (era Animales.php)
// Y de la clase a Animal, ya que cada objeto de esta clase almacena 1 solo animal

// Se añade un nuevo campo descripcion, y para reflejarlo en la base de datos, habrá que generar
//una migración con: php bin/console doctrine:migrations:diff, que creará un archivo en
// src/Migrations. Para ejecutar la migración y reflejarla en la base de datos habrá
// que ejecutar el comando: php bin/console doctrine:migrations:migrate

use Doctrine\ORM\Mapping as ORM;
 
//Para validar los campos según los criterios especificados con @Assert en cada campo
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Animales
 *
 * @ORM\Table(name="animales")
 * @ORM\Entity(repositoryClass="App\Repository\AnimalRepository")
 */
class Animal
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=255, nullable=false)
     * @Assert\NotBlank
     * @Assert\Regex("/[a-zA-Z]+/")
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=255, nullable=false)
     * @Assert\NotBlank
     * @Assert\Regex("/[a-zA-Z]+/")
     */
    private $color;

    /**
     * @var string
     *
     * @ORM\Column(name="raza", type="string", length=255, nullable=false)
     * @Assert\NotBlank
     * @Assert\Regex(
     *      pattern="/[a-zA-Z]+/",
     *      message="La raza debe ser un texto con letras")
     * )
     */
    private $raza;

    
    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=false)
     */
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

<?php
//Creado desde consola desde carpeta raiz del proyecto con: 
//     php bin/console make:twig-extension MiFiltro

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class MiFiltroExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('multiplicar', [$this, 'multiplicar']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('multiplicar', [$this, 'multiplicar']),
        ];
    }

    public function multiplicar($numero)
    {
        //Genera su tabla de multipliar
        $tabla ="<h1>Tabla del $numero </h1>";
        for ($i=0;$i<=10;$i++)
            $tabla .= "$i x $numero = ".($i*$numero)."<br>";
        return $tabla;
    }
    
    //Hay que registrar el filtro/funcion en los servicios de symfony
    // en config/services.yaml
}

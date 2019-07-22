<?php 

namespace App\Twig; // App\ car définit => composer.json

use Twig\TwigFilter;
use Twig\Extension\AbstractExtension;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return[
            new TwigFilter('price',[$this, 'priceFilter'])
        ];
    }

    public function priceFilter( $number ){
        return number_format($number, 2, ",", " "). " €";
    }
}
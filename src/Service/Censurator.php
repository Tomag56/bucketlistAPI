<?php

namespace App\Service;

class Censurator
{

    private array $motsCensures = ["aba","merde", "culé",  "fdp", "con"];
    function purify( $text)
    {
        $resultat = "";
//        $tableau = explode(" ", $text);
//        dd($tableau);
//        foreach ($this->motsCensures as $value) {
//            $resultat = str_replace($value, "*", $text);
//            dump($resultat);
//            dd($resultat);
//        }

//ireplace remplace les mots censurés par "*" dans text
            return str_ireplace($this->motsCensures, "*", $text);
//
    }
}
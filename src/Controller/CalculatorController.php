<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CalculatorController
{
    #[Route('/addition/{number1}/{number2}', name: 'app_calculator_addition')]
    public function addition($number1, $number2): Response {
        if ($number1 < 0 || $number2 < 0) {
            return new Response("<p>Au moins un nombre est négatif</p>");
        } else {
            return new Response("<p>L'addition de $number1 et $number2 est égale au résultat :".$number1 + $number2."</p>");
        }
    }

    #[Route('/calculatrice/{number1}/{number2}/{operator}', name: 'app_calculator_calculatrice')]
    public function calculatrice($number1, $number2, $operator): Response {
        switch ($operator) {
            case 'add':
                $message = "<p>L'addition de $number1 et $number2 est égale au résultat : ".$number1 + $number2."</p>";
                break;
            
            case 'sous':
                $message = "<p>La soustraction de $number1 par $number2 est égale au résultat : ".$number1 - $number2."</p>";
                break;
            
            case 'multi':
                $message = "<p>La multiplication de $number1 par $number2 est égale au résultat : ".$number1 * $number2."</p>";
                break;
            
            case 'div':
                if ($number2 == 0) $message = "Division par 0 impossible";
                else $message = "<p>La division de $number1 par $number2 est égale au résultat : ".$number1 / $number2."</p>";
                break;
            
            default:
                $message = "<p>Opérateur invalide</p>";
                break;
        }
        return new Response($message);
    }
}
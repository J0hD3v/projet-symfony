<?php

namespace App\Controller;

use App\Form\WeatherType;
use App\Service\WeatherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WeatherController extends AbstractController{
    public function __construct(
        private readonly WeatherService $weatherService
    ) {}
    
    public function home(): Response {
        return new Response ($this->weatherService->test());
    }

    #[Route('/weather', name: 'app_weather_display')]
    public function display(): Response
    {
        // dd($this->weather->getWeather());
        return $this->render('weather/display.html.twig', [
            'weather' => $this->weatherService->getWeather()
        ]);
    }

    #[Route('/weather/bycity', name: 'app_weather_displayByCity')]
    public function displayByCity(Request $request): Response
    {
        // Créer une objet Form
        $form = $this->createForm(WeatherType::class);
        // Récupération du résultat de la requête
        $form->handleRequest($request);

        // Si le formulaire est soumis
        if ($form->isSubmitted() && $form->isValid()) {
            $city = $request->request->all('weather')['ville'];
            try {
                $msg = '';
                $type = '';
                try {
                    $weather = $this->weatherService->getWeatherByCity($city);
                    $msg = "Ville valide";
                    $type = "success";
                } catch (\Throwable $th) {
                    $msg = "Ville invalide";
                    $type = "danger";
                }

            } catch (\Exception $e) {
                $msg = ($e->getMessage());
                $type = "danger";
            }
            $this->addFlash($type, $msg);
        }

        return $this->render('weather/searchweather.html.twig', [
            'formulaire' => $form,
            'weather' => $weather ?? ''
        ]);
    }
}

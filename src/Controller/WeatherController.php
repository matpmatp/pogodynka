<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\ForecastRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\WeatherUtil;

final class WeatherController extends AbstractController
{
    #[Route('/weather/{country?}/{city}', name: 'app_weather', requirements: ['id' => '\d+'])]
    public function city(
        #[MapEntity(mapping: ['city' => 'city', 'country' => 'country'])]
        Location $location,
        WeatherUtil $util,
        ?string $country = null
    ): Response
    {
        $forecasts = $util->getWeatherForLocation($location);

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'forecasts' => $forecasts,
            'controller_name' => 'WeatherController',
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Forecast;
use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpFoundation\Response;

final class WeatherApiController extends AbstractController
{
    #[Route('/api/v1/weather', name: 'app_weather_api', methods: ['GET'])]
    public function index(
        #[MapQueryParameter] string $country,
        #[MapQueryParameter] string $city,
        #[MapQueryParameter] string $format = 'json',
        #[MapQueryParameter('twig')] bool $twig = false,
        WeatherUtil $weatherUtil,
    ): Response {
        $forecasts = $weatherUtil->getWeatherForCountryAndCity($country, $city);

        if ($twig) {
            if ($format === 'csv') {
                return $this->render('weather_api/index.csv.twig', [
                    'city' => $city,
                    'country' => $country,
                    'forecasts' => $forecasts,
                ], new Response('', Response::HTTP_OK, ['Content-Type' => 'text/csv']));
            }

            return $this->render('weather_api/index.json.twig', [
                'city' => $city,
                'country' => $country,
                'forecasts' => $forecasts,
            ], new Response('', Response::HTTP_OK, ['Content-Type' => 'application/json']));
        }


        if ($format === 'csv') {
            $csvLines = [
                'city,country,date,celsius,Fahrenheit,pressure,condition,precipitation,humidity',
            ];

            foreach ($forecasts as $m) {
                $csvLines[] = sprintf(
                    '%s,%s,%s,%s,%s,%s,%s,%s,%s',
                    $city,
                    $country,
                    $m->getDate()->format('Y-m-d'),
                    $m->getTemperature(),
                    $m->getFahrenheit(),
                    $m->getPressure(),
                    $m->getCondition(),
                    $m->getPrecipitation(),
                    $m->getHumidity()
                );
            }

            $csvContent = implode("\n", $csvLines);

            return new Response($csvContent, Response::HTTP_OK, [
                'Content-Type' => 'text/csv',
            ]);
        }

        return $this->json([
            'city' => $city,
            'country' => $country,
            'forecasts' => array_map(fn(Forecast $m) => [
                'date' => $m->getDate()->format('Y-m-d'),
                'celsius' => $m->getTemperature(),
                'Fahrenheit' => $m->getFahrenheit(),
                'pressure' => $m->getPressure(),
                'condition' => $m->getCondition(),
                'precipitation' => $m->getPrecipitation(),
                'humidity' => $m->getHumidity(),
            ], $forecasts),
        ]);
    }
}

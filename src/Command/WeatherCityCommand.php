<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\WeatherUtil;

#[AsCommand(
    name: 'weather:city',
    description: 'Displays weather forecasts for a given country code and city name',
)]
class WeatherCityCommand{
    public function __construct(
        private readonly WeatherUtil $weatherUtil,
    ) {
    }
    public function __invoke(
        SymfonyStyle $io,
        #[Argument('Two-letter country code (e.g. PL)')] string $country,
        #[Argument('City name (e.g. Szczecin)')] string $city,
    ): int {
        $forecasts = $this->weatherUtil->getWeatherForCountryAndCity($country, $city);
        if (empty($forecasts)) {
            $io->warning(sprintf('No forecasts found for %s, %s.', $city, $country));
            return Command::SUCCESS;
        }
        $io->writeln(sprintf('Location: %s, %s', $city, $country));
        $io->table([
            'Date',
            'Temperature',
            'Pressure',
            'Condition',
            'Precipitation',
            'Humidity'
        ], array_map(fn($m) => [
            $m->getDate()->format('Y-m-d'),
            $m->getTemperature(),
            $m->getPressure(),
            $m->getCondition(),
            $m->getPrecipitation(),
            $m->getHumidity()
        ], $forecasts));

        return Command::SUCCESS;
    }
}

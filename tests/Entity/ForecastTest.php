<?php

namespace App\Tests\Entity;

use App\Entity\Forecast;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ForecastTest extends TestCase
{
    public static function dataGetFahrenheit(): array
    {
        return [
            ['0', '32'],
            ['-100', '-148'],
            ['100', '212'],
            ['0.5', '32.9'],
            ['-40', '-40'],
            ['20', '68'],
            ['36.6', '97.88'],
            ['-0.5', '31.1'],
            ['21.5', '70.7'],
            ['-10.5', '13.1'],
        ];
    }

    #[DataProvider('dataGetFahrenheit')]
    public function testGetFahrenheit(string $celsius, string $expectedFahrenheit): void
    {
        $forecast = new Forecast();

        $forecast->setTemperature($celsius);
        $this->assertEquals((float) $expectedFahrenheit, $forecast->getFahrenheit());
    }

    public function test(): void
    {
        $forecast = new Forecast();

        $forecast->setTemperature(0);
        $this->assertEquals(32, $forecast->getFahrenheit());

        $forecast->setTemperature(-100);
        $this->assertEquals(-148, $forecast->getFahrenheit());

        $forecast->setTemperature(100);
        $this->assertEquals(212, $forecast->getFahrenheit());
    }
}

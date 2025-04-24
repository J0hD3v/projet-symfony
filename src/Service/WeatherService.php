<?php
namespace App\Service;
use Symfony\Contracts\HttpClient\HttpClientInterface;
class WeatherService{
    public function __construct(
        private string $apikey,
        private HttpClientInterface $client
    ) {}

    public function test(): string {
        return $this->apikey;
    }

    public function getWeather() {
        $response = $this->client->request(
            'GET',
            'https://api.openweathermap.org/data/2.5/weather?lon=1.44&lat=43.6&appid=' . $this->apikey
        );
        $data = $response->getContent();
        $data = $response->toArray();
        return $data;
    }

    public function getWeatherByCity(string $city) {
        $response = $this->client->request(
            'GET',
            'https://api.openweathermap.org/data/2.5/weather?q=' . $city . '&appid=' . $this->apikey
        );
        $data = $response->getContent();
        $data = $response->toArray();
        return $data;
    }
}
<?php

declare(strict_types=1);

namespace App\Client;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class WeatherApiClient
{
    public function __construct(
        private string $weatherApiUrl,
        private string $weatherApiKey,
        private HttpClientInterface $client,
    ) {}

    /**
     * @return array<mixed> weather data
     */
    public function getCurrentWeatherByCity(string $city): array
    {
        try {
            [$location, $currentWeather] = $this->getCurrentWeatherByCityFromAPI('current.json', $city);
            $icon = $currentWeather['condition']['icon'] ?? null;
            if (null !== $icon) {
                $icon = "https:{$icon}";
            }

            return [
                'city' => $location['name'],
                'cityLocalTime' => $location['localtime'],
                'temperature' => $currentWeather['temp_c'],
                'feelslike' => $currentWeather['feelslike_c'],
                'icon' => $icon,
                'windSpeed' => $currentWeather['wind_kph'],
                'humidity' => $currentWeather['humidity'],
                'uv' => $currentWeather['uv'],
                'requestedAt' => (new \DateTime())->format('Y-m-d H:i:s'),
            ];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * @return array<int,array<array<string,int|string>|float|int|string>> weather data
     */
    private function getCurrentWeatherByCityFromAPI(string $url, string $city): array
    {
        $response = $this->client->request(
            Request::METHOD_GET,
            "{$this->weatherApiUrl}/{$url}",
            ['query' => $this->prepareRequestParamters($city)],
        );

        if (Response::HTTP_OK !== $response->getStatusCode()) {
            throw new \Exception('Error when calling WeatherApi API.');
        }

        $results = $response->toArray();
        if (
            [] === $results['location'] ||
            [] === $results['current']
        ) {
            // throw new \Exception('Data unavailable from WeatherApi API.');
            // Sometimes API does not return 'current' value because this is a test acount.
            // For this reason we've added some fake data instead of throwing an error. No need to make a subscription because this is only a test.
            $results = $this->getFakeData($results);
        }

        return [
            $results['location'],
            $results['current'],
        ];
    }

    /**
     * @return array<string> weatherApi query request parameters
     */
    private function prepareRequestParamters(string $city): array
    {
        return [
            'lang' => 'fr',
            'key' => $this->weatherApiKey,
            'q' => $city,
        ];
    }

    /**
     * @param array<string,array<array<string,int|string>|float|int|string>> $results weather data returned from WeatherApi API
     *
     * @return array<string,array<array<string,int|string>|float|int|string>> weather data
     */
    private function getFakeData(array $results): array
    {
        return [
            'location' => array_merge([
                'name' => 'Paris',
                'region' => 'Ile-de-France',
                'country' => 'France',
                'lat' => 48.87,
                'lon' => 2.33,
                'tz_id' => 'Europe/Paris',
                'localtime_epoch' => 1701543545,
                'localtime' => '2023-12-02 19:59',
            ], $results['location']),
            'current' => array_merge([
                'last_updated_epoch' => 1673620200,
                'last_updated' => '2023-01-13 14:30',
                'temp_c' => 11.0,
                'temp_f' => 51.8,
                'is_day' => 1,
                'condition' => [
                    'text' => 'Partly cloudy',
                    'icon' => '//cdn.weatherapi.com/weather/64x64/day/116.png',
                    'code' => 1003,
                ],
                'wind_mph' => 23.0,
                'wind_kph' => 37.1,
                'wind_degree' => 270,
                'wind_dir' => 'W',
                'pressure_mb' => 1010.0,
                'pressure_in' => 29.83,
                'precip_mm' => 0.0,
                'precip_in' => 0.0,
                'humidity' => 58,
                'cloud' => 75,
                'feelslike_c' => 8.1,
                'feelslike_f' => 46.5,
                'vis_km' => 10.0,
                'vis_miles' => 6.0,
                'uv' => 2.0,
                'gust_mph' => 22.4,
                'gust_kph' => 36.0,
            ], $results['current']),
        ];
    }
}

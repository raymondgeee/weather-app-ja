<?php

namespace App\Services;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class OpenWeatherService
{
    private const OPEN_WEATHER_API_URL = "https://api.openweathermap.org/data/2.5/weather?";

    public function weather($city)
    {
        $client = new Client();

        $url = self::OPEN_WEATHER_API_URL
                ."q=".$city
                ."&appid=".env("OPEN_WEATHER_API_KEY")
                ."&units=metric";

        try {
            $response = $client->request('GET', $url);

            $data = [
                "status" => $response->getStatusCode(),
                "data" => json_decode($response->getBody())
            ];

            return $data;
        } catch(GuzzleException $e) {
            Log::Error($e);
        }
    }
}

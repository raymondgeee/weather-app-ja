<?php

namespace App\Services;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class FourSquareService
{
    private const FOUR_SQUARE_API = "https://api.foursquare.com/v3/autocomplete?";
    private const LAT_LONG_JP = "36.2048,138.2529";
    private const RADIUS = 200000;
    private const LIMIT = 5;
    private const TYPE = "place";

    public function places($city)
    {
        $client = new Client();
        try {
            $response = $client->request("GET",
            self::FOUR_SQUARE_API
            ."query=".$city
            ."&ll=".self::LAT_LONG_JP
            ."&radius=".self::RADIUS
            ."&limit=".self::LIMIT
            ."&types=".self::TYPE, [
                "headers" => [
                    "Authorization" => env("FOUR_SQUARE_API_KEY"),
                    "Accept" => "application/json",
                ],
            ]);

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

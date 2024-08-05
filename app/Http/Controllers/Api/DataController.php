<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FourSquareService;
use App\Services\OpenWeatherService;

class DataController extends Controller
{
    protected FourSquareService $fourSquareService;
    protected OpenWeatherService $openWeatherService;

    public function __construct()
    {
        $this->FourSquareService = new FourSquareService();
        $this->OpenWeatherService = new OpenWeatherService();
    }

    public function getCityDetails($city)
    {
        $data = [
            "places" => $this->FourSquareService->places($city),
            "weather" => $this->OpenWeatherService->weather($city)
        ];

        return $data;
    }
}
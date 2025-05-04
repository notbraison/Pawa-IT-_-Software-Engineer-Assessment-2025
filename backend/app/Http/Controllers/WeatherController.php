<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WeatherController extends Controller
{
    //
    public function retreive(Request $request)
    {
        $city = $request->input('city');
        $api = config('services.openweather.key');
        $url = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$api}&units=metric";
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        if (isset($data['main'])) {
            $temperature = $data['main']['temp'];
            $humidity = $data['main']['humidity'];
            $description = $data['weather'][0]['description'];
            return response()->json([
                'temperature' => $temperature,
                'humidity' => $humidity,
                'description' => $description
            ]);
        } else {
            return response()->json(['error' => 'City not found'], 404);
        }
}
}


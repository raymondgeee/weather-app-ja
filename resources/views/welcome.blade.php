<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Japan - Weather App</title>
        @vite(['resources/js/app.js', 'resources/css/app.css', 'resources/sass/app.scss'])
    </head>
    <body>
        <div id="app"></div>
    </body>
</html>

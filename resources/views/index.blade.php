<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PETS project</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="/js/app.js" defer></script>
    <body>
        <div id="app">
            <index></index>
        </div>
    </body>
</html>

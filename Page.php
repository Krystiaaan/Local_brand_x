<?php declare(strict_types=1);
abstract class Page {
    
    protected MySQLi $_db;
    
    protected function __construct()
    {
        error_reporting(E_ALL);

    }
    protected function getAPIData(string $location, ?string $country = null): array 
    {
        $endpoint = 'current';

        $locationEncoded = urlencode($location);
        $query_params = "postal_code={$location}";

        if($country !== null){
            $query_params .= "&country={$country}";
        }
        //APP ID here maps: rJ6uIoFYguyNhomOtiZE
        //API KEY here maps: h1bCmu1tmdSnD-yPl_WvuFPWbEBQKKwfNSW36zSwUl8

        //checking if the input is numeric or no
        if(ctype_digit($location)){
            $apiUrl = "https://api.weatherbit.io/v2.0/{$endpoint}?{$query_params}&key={$apiKey}"; //Api url for postal code
        }else {
            $apiUrl = "https://api.weatherbit.io/v2.0/{$endpoint}?city={$locationEncoded}&key={$apiKey}"; //Api url for city
        }
        $response = file_get_contents($apiUrl);

        if ($response === false) {
            throw new Exception('Fehler beim Abrufen von Daten von der API');
        }
        $data = json_decode($response, true);
        return $data;
    }
    
    protected function generatePageHeader(string $title = "" , string $jsFile = ""):void
    {
        $title = htmlspecialchars($title);
        header("Content-type: text/html; charset=UTF-8");
        echo <<< HEADERHTML
        <!DOCTYPE html>

        <html lang="de">

        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" type="text/css" href="style.css">
            <title>$title</title>
            <script src="index.js"></script>
            <script src="https://js.api.here.com/v3/3.1/mapsjs-core.js" type="text/javascript" charset="utf-8"></script>
            <script src="https://js.api.here.com/v3/3.1/mapsjs-service.js" type="text/javascript" charset="utf-8"></script>
            <script src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js" type="text/javascript" charset="utf-8"></script>
            <script src="https://js.api.here.com/v3/3.1/mapsjs-ui.js" type="text/javascript" charset="utf-8"></script>
HEADERHTML;
        if($jsFile != ""){
            echo "<script src=$jsFile></script>";
        }
        echo "</head>";
    }


    protected function generatePageFooter():void
    {

    }
}

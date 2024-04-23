<?php declare(strict_types=1);

require_once "Page.php";

class index extends Page{

    protected function __construct()
    {
        parent::__construct();
    }
    protected function getViewData(): array
    {
        return array();
    }
    protected function generateView(array $data): void{
        $this->generatePageHeader("Wetter Local Brand X");
        //form for sending City Name or Postal Code
        ECHO <<< HTML
        <div class="container-form">
        <form action="index.php" method="get" id="weatherForm">
            <h2>Wetter for Local Brand X</h2>
            <label for="location">Enter City Name or Postal Code:</label><br>
            <input type="text" id="location" name="location" required><br>
            <label for="country">Country (optional):</label><br>
            <input type="text" id="country" name="country"><br>
            <input type="submit" value="Get Weather">
        </form>
    </div>
HTML;
        
        if(!empty($data['data'][0]) && isset($data['data'][0]['city_name'])){  
            $city = $data['data'][0]['city_name'];
            $clouds = $data['data'][0]['clouds'];
            $datetime = $data['data'][0]['datetime']; 
            $temperature = $data['data'][0]['temp'];
            $sunrise = $data['data'][0]['sunrise'];
            $sunset = $data['data'][0]['sunset'];

            
            $latitude = $data['data'][0]['lat'];
            $longitude = $data['data'][0]['lon'];

        ECHO <<< HTML
        <div class="container">
            <div>City: {$city}</div>
            <div>Clouds: {$clouds}</div>
            <div>Date: {$datetime}</div> 
            <div>Temperature: {$temperature}</div>
            <div>Sunrise: {$sunrise}</div>
            <div>Sunset: {$sunset}</div>

            <!-- To pass it to javascript -->
            <div id="latitude" style="display: none;">{$latitude}</div>
            <div id="longitude" style="display: none;">{$longitude}</div>
        </div>
HTML;
        }else {
            echo "<div class='container'>No weather data available for the specified location.</div>";
        }
        ECHO <<< HTML
        <div id="mapContainer" style="width: 500px; height: 500px;"></div>

HTML;
        $this->generatePageFooter();
    }

    protected function processReceivedData(): array
    {
        //processing input and sending to getAPIDATA
        if(isset($_GET["location"])){
            $location = $_GET["location"];
            $country = '';
            if(isset($_GET["country"])){
                $country = $_GET["country"];
            }
            $data = $this->getAPIData($location, $country);
          
            if(empty($data['data'])){
                throw new Exception("No weather data available for the specified location");
            }  
            return $data;
        }
        return [];
    }

    public static function main(): void 
    {
        try{
            $page = new index();
            $data = $page->processReceivedData();
            //$data from processreceivedData send to generateview
            $page->generateView($data);
        }catch(Exception $e){
            header("Content-type: text/html; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

index::main();
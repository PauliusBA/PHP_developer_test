<?php
$apiKey = "a0c255a0bf59e3ffd26016f21ab12548";
$cityId = "2174003";
$currentWeatherApi = "http://api.openweathermap.org/data/2.5/forecast?id=" . $cityId . "&lang=en&units=metric&APPID=" . $apiKey;


// cURL session and fetching from OpenWeather web page

$ch = curl_init();

curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $currentWeatherApi);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_VERBOSE, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);

curl_close($ch);
$data = json_decode($response);
$currentTime = time();

$sunrise=$data->city->sunrise;
 // IMO Open weather is giving a sunset time istead of sunrise and ~few hour ahead
//swapped around in html for accuracy
$sunset=$data->city->sunset; 
//IMO Open weather is giving a sunrse time istead of sunset / and ~few hours ahead
//swapped around in html for accuracy


?>

<!doctype html>
<html>
<head>
<title>Current/ 3 day weather forecast </title>


<!-- STYLES -->
<style>
body {
    font-family: Arial;
    font-size: 0.95em;
    color: #929292;
}
h2 {
    font-size: 40px;
}
.weather-app  {
    position: relative;
    padding: 20px 40px 40px 40px;
    border-radius: 2px;
    width: 800px;
    margin: 0 auto;
    text-align: center; 
    color: white;
    box-shadow: 0 0 20px black;
}
.bg-image {
    position: absolute;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: -3;
}
.dark-overlay {
    position: absolute;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    background-color: black;
    opacity: 0.6;
    z-index: -3;
}

h2 span{
    font-size: 50px;
}

.weather-icon {
    vertical-align: middle;
    margin-right: 20px;
}

.weather-forecast {
    font-size: 1.2em;
    font-weight: bold;
    margin: 20px 0px;
}

.max-temperature {
    margin-left: 15px;
    color: #e79c9c;
}
.min-temperature {
    margin-left: 15px;
    color: #aaaac4;
}

.time {
    line-height: 25px;
    margin-bottom: 20px;
}
.forecast {
    display: flex;
    justify-content: space-between;
}
.weekday {
    display: flex;
    flex-direction: column;
}
.weekday img {
    width: 50px;
    height: 50px;
    margin: 0 auto;
}

.by-hour span{
    display: block;
    margin-bottom: 5px;
}
.by-hour {
    font-size: 10px;
    color: #b3a8a8;
}


</style>

</head>
<body>
     
    <div class="weather-app container">
        <h2> Current weather <br>
        <span> <?php echo $data->city->name;?> </span> </h2>
        <div class="time">
            <div><?php echo date("jS F, Y",$currentTime); ?> </div>
            <div><?php echo ucwords($data->list[0]->weather[0]->description); ?></div>
        </div>
        <div class="weather-forecast">
            <img src="http://openweathermap.org/img/w/<?php echo $data->list[0]->weather[0]->icon; ?>.png"class="weather-icon" /> 
            <span style="font-size: 40px;"><?php echo (round($data->list[0]->main->temp)); ?>&deg;C  </span> <br>

            <span class="max-temperature"> Max temp: <?php echo (round($data->list[0]->main->temp_max));?>&deg;C </span>
            <span class="min-temperature"> Min temp: <?php echo (round($data->list[0]->main->temp_min)); ?>&deg;C</span> <br><br>
            <span> Feels like <?php echo (round($data->list[0]->main->feels_like)); ?> &deg;C </span> <br><br>
            <span> Sunrise: <?php echo gmdate("H:i:s", $sunset); ?> </span>  <br> 
            <span> Sunset: <?php echo gmdate("H:i:s", $sunrise); ?> </span>    
        </div>
        <div class="time">
            <div>Humidity: <?php echo $data->list[0]->main->humidity; ?> %</div>
            <div>Wind: <?php echo $data->list[0]->wind->speed; ?> km/h</div>
        </div>
        <div class="forecast">
           <div class="weekday">
              <p class="day1"></p>
              <img src="http://openweathermap.org/img/w/<?php echo $data->list[8]->weather[0]->icon; ?>.png"class="weather-icon" /> 
              <p><?php echo ucwords($data->list[8]->weather[0]->description); ?></p>
              <p><?php echo (round($data->list[8]->main->temp)); ?>&deg;C </p>
              <p class="by-hour">
                  <span>
                  9 am  <br>
                  <?php echo ucwords($data->list[6]->weather[0]->description); ?> <br>
                  <?php echo (round($data->list[6]->main->temp)); ?>&deg;C  <br>
                  Humidity: <?php echo $data->list[6]->main->humidity; ?> %  <br>
                  </span> 
                  <span>
                  12 am  <br>
                  <?php echo ucwords($data->list[7]->weather[0]->description); ?> <br>
                  <?php echo (round($data->list[7]->main->temp)); ?>&deg;C  <br>
                  Humidity: <?php echo $data->list[7]->main->humidity; ?> %  <br></span>
                  <span>
                  15 pm  <br>
                  <?php echo ucwords($data->list[8]->weather[0]->description); ?> <br>
                  <?php echo (round($data->list[8]->main->temp)); ?>&deg;C  <br>
                  Humidity: <?php echo $data->list[8]->main->humidity; ?> %  <br></span>
                  </span>
              </p>
           </div>
           <div class="weekday">
              <p class="day2"></p>
              <img src="http://openweathermap.org/img/w/<?php echo $data->list[16]->weather[0]->icon; ?>.png"class="weather-icon" /> 
              <p><?php echo ucwords($data->list[16]->weather[0]->description); ?></p>
              <p><?php echo (round($data->list[16]->main->temp)); ?>&deg;C </p>
              <p class="by-hour">
                 <span>
                  9 am  <br>
                  <?php echo ucwords($data->list[14]->weather[0]->description); ?> <br>
                  <?php echo (round($data->list[14]->main->temp)); ?>&deg;C  <br>
                  Humidity: <?php echo $data->list[14]->main->humidity; ?> %  <br>
                  </span> 
                  <span>
                  12 am  <br>
                  <?php echo ucwords($data->list[15]->weather[0]->description); ?> <br>
                  <?php echo (round($data->list[15]->main->temp)); ?>&deg;C  <br>
                  Humidity: <?php echo $data->list[15]->main->humidity; ?> %  <br></span>
                  <span>
                  15 pm  <br>
                  <?php echo ucwords($data->list[16]->weather[0]->description); ?> <br>
                  <?php echo (round($data->list[16]->main->temp)); ?>&deg;C  <br>
                  Humidity: <?php echo $data->list[16]->main->humidity; ?> %  <br></span>
                  </span>
              </p>
           </div>
           <div class="weekday">
              <p class="day3"></p>
              <img src="http://openweathermap.org/img/w/<?php echo $data->list[24]->weather[0]->icon; ?>.png"class="weather-icon" /> 
              <p><?php echo ucwords($data->list[24]->weather[0]->description); ?></p>
              <p><?php echo (round($data->list[24]->main->temp)); ?>&deg;C </p>
              <p class="by-hour">
                  <span>
                  9 am  <br>
                  <?php echo ucwords($data->list[23]->weather[0]->description); ?> <br>
                  <?php echo (round($data->list[23]->main->temp)); ?>&deg;C  <br>
                  Humidity: <?php echo $data->list[23]->main->humidity; ?> %  <br>
                  </span> 
                  <span>
                  12 am  <br>
                  <?php echo ucwords($data->list[23]->weather[0]->description); ?> <br>
                  <?php echo (round($data->list[23]->main->temp)); ?>&deg;C  <br>
                  Humidity: <?php echo $data->list[23]->main->humidity; ?> %  <br></span>
                  <span>
                  15 pm  <br>
                  <?php echo ucwords($data->list[23]->weather[0]->description); ?> <br>
                  <?php echo (round($data->list[23]->main->temp)); ?>&deg;C  <br>
                  Humidity: <?php echo $data->list[23]->main->humidity; ?> %  <br></span>
                  </span>
              </p>
           </div>
        </div>
    <img class="bg-image" src="bg-image.jpg"/>   
    <div class="dark-overlay"></div>    
    </div>

<script>


// Weekdays

// Tommorow
var tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    document.querySelector('.day1').innerText= getWeekDay(tomorrow);
//Day after tommorow
var dayafter1 = new Date();
    dayafter1.setDate(dayafter1.getDate() + 2);
    document.querySelector('.day2').innerText= getWeekDay(dayafter1);

//2 days after tommorow
var dayafter2 = new Date();
    dayafter2.setDate(dayafter2.getDate() + 3);
    document.querySelector('.day3').innerText= getWeekDay(dayafter2);

// forecast

function getWeekDay(date){
    //Create an array containing each day, starting with Sunday.
    var weekdays = new Array(
        "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"
    );
    //Use the getDay() method to get the day.
    var day = date.getDay();
    //Return the element that corresponds to that index.
    return weekdays[day];
}
</script>









</body>
</html>
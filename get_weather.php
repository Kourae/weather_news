<?php
$lat = $_GET['lat'];
$lon = $_GET['lon'];
$url = "https://api.open-meteo.com/v1/forecast?latitude=$lat&longitude=$lon&current_weather=true";

$weather = file_get_contents($url);
echo $weather;
?>

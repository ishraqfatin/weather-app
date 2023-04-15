<?php

$api_key = "bbd0ab2cb5be0e393ae3687c6cb257ab";

$url = "http://api.openweathermap.org/data/2.5/forecast?q=Dhaka&appid=bbd0ab2cb5be0e393ae3687c6cb257ab";
$weather_data = file_get_contents($url);
$weather_data = json_decode($weather_data, true);

$city_name = $weather_data['city']['name'];
$country_code = $weather_data['city']['country'];

$forecast_data = array();
foreach ($weather_data['list'] as $data) {
	$date = date("D, M j, Y", strtotime($data['dt_txt']));
	$time = date('g:i A', strtotime($data['dt_txt']));
	$temperature = round($data['main']['temp'] - 273.15); // convert from Kelvin to Celsius and round to nearest integer
	$weather_description = $data['weather'][0]['description'];
	$forecast_data[$date][] = array(
		'time' => $time,
		'temperature' => $temperature,
		'weather_description' => $weather_description
	);
}
?>
<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Weather-More</title>
		<link rel="stylesheet" href="style.css">
	</head>

	<body>
		<h1>5 days weather forcast for:
			<?php echo $city_name ?>
		</h1>
		<div class="forecast">
			<?php foreach ($forecast_data as $date => $data): ?>
				<div class="card">
					<div class="date">
						<?php echo $date; ?>
						<!-- <hr> -->
					</div>
					<?php foreach ($data as $item): ?>
						<div class="time">
							<?php echo $item['time']; ?>
						</div>
						<div class="temperature">
							<?php echo $item['temperature']; ?>&deg;C
						</div>
						<div class="weather-description">
							<?php echo $item['weather_description']; ?>
						</div>
						<hr>
					<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</body>

</html>
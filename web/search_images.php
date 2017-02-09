<?php

$curl = curl_init();

//$url = "https://planetakino.ua/odessa2/movies/archive/";

curl_setopt($curl, CURLOPT_URL, 'https://planetakino.ua/odessa2/movies/archive/');
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($curl);
preg_match_all("!/f/1/movies/[^\s]*?.jpg!", $result, $matches);

$images = array_values(array_unique($matches[0]));

for ($i = 0; $i < count ($images); $i++) 
	{
		echo "<div style='float: left; margin 10 0 0 0; '>";
		echo '<img src="https://planetakino.ua' . $images[$i] . '"><br />';
		echo "</div>";
	}

curl_close($curl);
?>

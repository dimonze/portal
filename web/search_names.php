<?php

$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, 'https://planetakino.ua/odessa2/movies/archive/');
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($curl);
preg_match_all("!/movies/[^\s]*?/!", $result, $matches);

$names = array_unique($matches[0]);

print_r($names);

curl_close($curl);
?>

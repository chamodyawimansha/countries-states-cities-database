<?php

$file = file_get_contents("../countries+states+cities.json");

$jsonIterator = new RecursiveIteratorIterator(new RecursiveArrayIterator(json_decode($file, TRUE)),RecursiveIteratorIterator::SELF_FIRST);

$country_array = [];

$data = json_decode($file, TRUE);

foreach ($data as $val) {
  $arr = [
    'country'       => $val['name'],
    'phone_code'    => $val['phone_code'],
    'currency'      => $val['currency'],
    'iso2'          => $val['iso2'],
    'iso3'          => $val['iso3'],
    'currency_name' => $val['currency_name'],
    'region'        => $val['region'],
    'timezone'      => $val['timezones'][0]['zoneName'],
    'states'        => array_map(function ($state) {
      return [
        'name'      => $state['name'],
        'cities'    => array_map(function ($city) {
          return $city['name'];
        }, $state['cities']),
      ];
    }, $val['states']),
  ];

 array_push($country_array, $arr);
}

$file = fopen("countires.json", "w");
fwrite($file, json_encode($country_array));

fclose($file);
<?php
include('db_connect.php');
$query_cities = '
  INSERT INTO cities(city_name)
  VALUES("Владивосток"), ("Хабаровск"), ("Новосибирск");';
$mysqli->query($query_cities);

$query_streets = '
  INSERT INTO streets(street_name)
  VALUES("Океанская"), ("Садовая"), ("Нерчинская"), ("Ленинская");';
$mysqli->query($query_streets);

$t = 'INSERT INTO city_street(street_id, city_id)
  VALUES(1, 1), (2, 1), (3, 2), (4, 3);';
$mysqli->query($t);


<?php
include('db_connect.php');
if (!empty($_POST['word'])) {
  $get_cities_query = '
    SELECT
      cities.id,
      cities.city_name
    FROM cities
    WHERE cities.city_name LIKE "' . $_POST['word'] . '%"
    ORDER BY city_name ASC;';
} else {
  $get_cities_query = '
  SELECT
    cities.id,
    cities.city_name
  FROM cities
  ORDER BY city_name ASC
  LIMIT 10;';
}

if ($res_cities = $mysqli->query($get_cities_query)) {
  $arr_cities = array();
  while ($row_city = $res_cities->fetch_assoc()) {
    $arr_cities[] = $row_city;
  }
}

echo json_encode($arr_cities);


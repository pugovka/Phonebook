<?php
include('db_connect.php');

$get_streets_query = '
  SELECT
    streets.id,
    streets.street_name
  FROM streets
  INNER JOIN city_street on streets.id=city_street.street_id
  WHERE city_street.city_id=' . $_POST['city_id'] . '
  ORDER BY street_name ASC;';

if ($res_streets = $mysqli->query($get_streets_query)) {
  $arr_streets = array();
  while ($row_street = $res_streets->fetch_assoc()) {
    $arr_streets[] = $row_street;
  }
}

echo json_encode($arr_streets);

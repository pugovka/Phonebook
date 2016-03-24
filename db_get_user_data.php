<?php
include('db_connect.php');

$get_user_query = '
  SELECT
    phonebook.id,
    phonebook.last_name,
    phonebook.first_name,
    phonebook.second_name,
    cities.city_name,
    cities.id as city_id,
    streets.street_name,
    streets.id as street_id,
    phonebook.birth_date,
    phonebook.phone_number
  FROM phonebook
  LEFT JOIN cities ON phonebook.city_id=cities.id
  LEFT JOIN streets ON phonebook.street_id=streets.id
  WHERE phonebook.id="' . $_GET['record_id'] . '";';

if ($res_user = $mysqli->query($get_user_query)) {
  $arr_user = array();
  if ($row_user = $res_user->fetch_assoc()) {
    $arr_user = $row_user;
  }
}

echo json_encode($arr_user);

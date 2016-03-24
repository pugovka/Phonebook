<?php
include('db_connect.php');

$get_users_query = '
  SELECT
    phonebook.id,
    phonebook.last_name,
    phonebook.first_name,
    phonebook.second_name,
    IFNULL(cities.city_name, "") city_name,
    IFNULL(streets.street_name, "") street_name,
    phonebook.birth_date,
    phonebook.phone_number
  FROM phonebook
  LEFT JOIN cities ON phonebook.city_id=cities.id
  LEFT JOIN streets ON phonebook.street_id=streets.id
  ORDER BY last_name ASC;';

if ($res_users = $mysqli->query($get_users_query)) {
  $arr_users = array();
  while ($row_user = $res_users->fetch_assoc()) {
    $arr_users[] = $row_user;
  }
}
echo json_encode($arr_users);

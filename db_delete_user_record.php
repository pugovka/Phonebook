<?php
include('db_connect.php');

$user_query = 'DELETE FROM phonebook WHERE id="' . $_POST['record_id'] . '";';

if ($mysqli->query($user_query)) {
  echo json_encode(1);
}

<?php
include('db_connect.php');
// Check if fields are empty
$fields_validation = true;
$return = array();
if (
  !empty($_POST) && (
      empty($_POST['person_data']['last_name']) ||
      empty($_POST['person_data']['phone_number'])
    )
  ) {
  $fields_validation = false;
}
if (!$fields_validation) {
  $return['value'] = 0;
  $return['text'] = "Заполните фамилию и телефон.";
} else {
  // Check if person with this number exists
  $person_search_query = 'SELECT * FROM phonebook WHERE phone_number="' . $_POST['person_data']['phone_number'] . '";';
  if ($res_search = $mysqli->query($person_search_query)) {
    if ($res_search->num_rows === 0) {
      $insert_record = '
        INSERT INTO phonebook(
          last_name,
          first_name,
          second_name,
          city_id,
          street_id,
          birth_date,
          phone_number
        )
        VALUES(
          "' . $_POST['person_data']['last_name'] . '",
          "' . $_POST['person_data']['first_name'] . '",
          "' . $_POST['person_data']['second_name'] . '",
          "' . intval($_POST['person_data']['city_id']) . '",
          "' . intval($_POST['person_data']['street_id']) . '",
          "' . $_POST['person_data']['birth_date'] . '",
          "' . $_POST['person_data']['phone_number'] . '"
        );
      ';
      if ($mysqli->query($insert_record)) {
        $return['value'] = 1;
        $return['text'] = "Запись успешно добавлена.";
      } else {
        $return['value'] = 0;
        $return['text'] = "Ошибка при добавлении записи. ". $mysqli->error ;
      }
    } else {
      $return['value'] = 0;
      $return['text'] = "Запись с таким номером телефона уже существует.";
    }
  }
}
echo json_encode($return);

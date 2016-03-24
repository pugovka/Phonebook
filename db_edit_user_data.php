<?php
include('db_connect.php');
$return = array();
if (!empty($_POST['person_data']['id'])) {
  // Check if person with this number exists
  $person_search_query = 'SELECT * FROM phonebook WHERE id=' . $_POST['person_data']['id'] . ';';
  if ($res_search = $mysqli->query($person_search_query)) {
    if ($res_search->num_rows === 0) {
      $return['value'] = 0;
      $return['text'] = "Запись с таким номером телефона не существует.";
    } else {
      $insert_record = '
        UPDATE phonebook SET
          last_name="' . $_POST['person_data']['last_name'] . '",
          first_name="' . $_POST['person_data']['first_name'] . '",
          second_name="' . $_POST['person_data']['second_name'] . '",
          city_id=' . intval($_POST['person_data']['city_id']) . ',
          street_id=' . intval($_POST['person_data']['street_id']) . ',
          birth_date="' . $_POST['person_data']['birth_date'] . '",
          phone_number="' . $_POST['person_data']['phone_number'] . '"
        WHERE id=' . $_POST['person_data']['id'] . '
        ;';
      if ($mysqli->query($insert_record)) {
        $return['value'] = 1;
        $return['text'] = "Запись успешно обновлена.";
      } else {
        $return['value'] = 0;
        $return['text'] = "Ошибка при обновлении записи. ". $mysqli->error ;
      }
    }
  }
}
echo json_encode($return);

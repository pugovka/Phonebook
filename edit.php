<?php include('db_get_user_data.php'); ?>
<!DOCTYPE HTML>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="jquery_ui/jquery-ui.min.css">
  <link rel="stylesheet" href="jquery_ui/jquery-ui.structure.min.css">
  <link rel="stylesheet" href="jquery_ui/jquery-ui.theme.min.css">
  <link rel="stylesheet" href="css/styles.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="jquery_ui/jquery-ui.min.js"></script>
  <script src="js/jquery.maskedinput.min.js"></script>
  <script src="js/script.js"></script>
  <title>Изменить запись в телефонном справочнике</title>
  <meta name="description" content="Редактирование телефонного справочника">
</head>

<body>
<div class="content">
  <h1>Редактировать запись в справочнике</h1>
  <div class="phonebook-form__msg-block"></div>
  <form method="post" action="create_user_data.php" class="phonebook-form phonebook-form--edit" accept-charset="utf-8">
    <input type="hidden" name="person_data[id]"
           value="<?php echo $_GET['record_id']?>">
    <div class="phonebook-form__input-area">
      <label class="phonebook-form__label">Фамилия:</label>
      <input type="text" name="person_data[last_name]"
             class="phonebook-form__input"
             value="<?php echo $arr_user['last_name']?>"
             required maxlength="25">
    </div>
    <div class="phonebook-form__input-area">
      <label class="phonebook-form__label">Имя:</label>
      <input type="text" name="person_data[first_name]"
             class="phonebook-form__input"
             value="<?php echo $arr_user['first_name']?>"
             maxlength="25">
    </div>
    <div class="phonebook-form__input-area">
      <label class="phonebook-form__label">Отчество:</label>
      <input type="text" name="person_data[second_name]"
             class="phonebook-form__input"
             value="<?php echo $arr_user['second_name']?>"
             maxlength="25">
    </div>
    <div class="phonebook-form__input-area">
      <label class="phonebook-form__label">Город:</label>
      <input type="text" id="cities_input"
             class="phonebook-form__input"
             value="<?php echo $arr_user['city_name']?>"
             data-city-id="<?php echo $arr_user['city_id']?>">
    </div>
    <div class="phonebook-form__input-area">
      <label class="phonebook-form__label">Улица:</label>
      <select name="person_data[street_id]"
              class="phonebook-form__street-select phonebook-form__select"
              data-street-id="<?php echo $arr_user['street_id']?>">
        <option value="">Выберите улицу</option>
      </select>
    </div>
    <div class="phonebook-form__input-area">
      <label class="phonebook-form__label">Дата рождения:</label>
      <input type="text" name="person_data[birth_date]"
             id="datepicker" class="phonebook-form__input"
             value="<?php echo $arr_user['birth_date']?>"
             maxlength="25">
    </div>
    <div class="phonebook-form__input-area">
      <label class="phonebook-form__label">Телефон:</label>
      <input type="text" name="person_data[phone_number]"
             class="phonebook-form__input phonebook-form__phone-input"
             value="<?php echo $arr_user['phone_number']?>" required>
    </div>
    <div>
      <input type="submit" value="Сохранить" name="upd_record" class="phonebook-form__update">
      <a href="index.html">Вернуться</a>
    </div>
  </form>

</div>
</body>
</html>

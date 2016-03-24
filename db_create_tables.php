<?php
include('db_connect.php');

$create_table_phonebook =
  'CREATE TABLE IF NOT EXISTS phonebook(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    last_name VARCHAR(25) NOT NULL,
    first_name VARCHAR(25),
    second_name VARCHAR(25),
    city_id INT,
    street_id INT,
    birth_date VARCHAR(25),
    phone_number VARCHAR(25) NOT NULL UNIQUE
  );';

if ($mysqli->query($create_table_phonebook) === FALSE) {
  echo("Ошибка при создании таблицы телефонного справочника.\n");
} else {
  echo("Таблица успешно создана.\n");
}

$create_table_cities =
  'CREATE TABLE IF NOT EXISTS cities(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    city_name VARCHAR(25) NOT NULL
  );';

if ($mysqli->query($create_table_cities) === FALSE) {
  echo("Ошибка при создании таблицы городов.\n");
} else {
  echo("Таблица успешно создана.\n");
}

$create_table_streets =
  'CREATE TABLE IF NOT EXISTS streets(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    street_name VARCHAR(25) NOT NULL
  );';

if ($mysqli->query($create_table_streets) === FALSE) {
  echo("Ошибка при создании таблицы улиц.\n");
} else {
  echo("Таблица успешно создана.\n");
}

$create_table_street_city_query =
  'CREATE TABLE IF NOT EXISTS city_street(
    street_id INT NOT NULL UNIQUE,
    city_id INT NOT NULL ,
    primary key (city_id, street_id)
  );';

if ($mysqli->query($create_table_street_city_query) === FALSE) {
  echo("Ошибка при создании таблицы соответствия улиц и городов.\n");
} else {
  echo("Таблица успешно создана.\n");
}

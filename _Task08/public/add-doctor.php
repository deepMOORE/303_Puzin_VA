<?php declare(strict_types=1);

require_once 'app/Connection.php';

const SPECIALITY = 'speciality';
const FIRST_NAME = 'firstName';
const LAST_NAME = 'lastName';
const PATRONYMIC = 'patronymic';
const DATE_OF_BIRTH = 'dateOfBirth';

var_dump($_POST);

if (isset($_POST)) {
    $connection = Connection::sqlite3('data/clinic.db');

    $speciality = $_POST[SPECIALITY];
    $firstName = $_POST[FIRST_NAME];
    $lastName = $_POST[LAST_NAME];
    $patronymic = $_POST[PATRONYMIC];
    $dateOfBirth = $_POST[DATE_OF_BIRTH];

    $connection->exec("insert into specialties (title) values ('ppp')");
}
?>
<?php declare(strict_types=1);

require_once __DIR__ . '/../../../app/Connection.php';
require_once __DIR__ . '/../../../app/DataAccess/ReceptionsRepository.php';
require_once __DIR__ . '/../../../app/DataAccess/DoctorsRepository.php';
require_once __DIR__ . '/../../../app/Models/DoctorCreateModel.php';
require_once __DIR__ . '/../../../app/Utils/ParametersValidator.php';

require_once '../../../vendor/autoload.php';
require_once __DIR__ . '/../../../app/DataAccess/SpecialtiesRepository.php';

use RedBeanPHP\R;

const DB_PATH = __DIR__ . '/../data/clinic.db';

$connectionString = 'sqlite:' . realpath(DB_PATH);

R::setup($connectionString);

$doctorsRepository = new DoctorsRepository();

$specialtyId = (int)$_POST['specialtyId'];
$firstName = (string)$_POST['firstName'];
$lastName = (string)$_POST['lastName'];
$patronymic = (string)$_POST['patronymic'];
$earningInPercents = (int)$_POST['earningInPercents'];
try {
    $dateOfBirth = new DateTime($_POST['dateOfBirth']);
} catch (Exception $exception) {
    echo 'Wrong date, check placeholder';
    die();
}

$model = new DoctorCreateModel(
    $specialtyId,
    $firstName,
    $lastName,
    $patronymic,
    $earningInPercents,
    $dateOfBirth
);

try {
    $doctorId = $doctorsRepository->create($model);
} catch (Exception $exception) {
    echo 'Something went wrong';
}

echo 'Success! Doctor ID: ' . $doctorId . PHP_EOL;
echo '<a href="add-doctor-form.php" class="add-doctor-button">Add another one.</a>';

<?php declare(strict_types=1);

use RedBeanPHP\R;
require_once '../../../vendor/autoload.php';

require_once __DIR__ . '/../../../app/DataAccess/ReceptionsRepository.php';
require_once __DIR__ . '/../../../app/DataAccess/DoctorsRepository.php';
require_once __DIR__ . '/../../../app/Models/DoctorUpdateModel.php';

const DB_PATH = __DIR__ . '/../../../data/clinic.db';

$connectionString = 'sqlite:' . realpath(DB_PATH);

R::setup($connectionString);

$doctorsRepository = new DoctorsRepository();

$specialtyId = (int)$_POST['specialtyId'];
$id = (int)$_POST['doctorId'];
$firstName = (string)$_POST['firstName'];
$lastName = (string)$_POST['lastName'];
$patronymic = (string)$_POST['patronymic'];
$earningInPercents = (int)$_POST['earningInPercents'];
$statusId = (int)$_POST['statusId'];
$dateOfBirth = new DateTime($_POST['dateOfBirth']);

$model = new DoctorUpdateModel($id, $specialtyId, $firstName, $lastName, $patronymic, $earningInPercents, $dateOfBirth, $statusId);

try {
    $doctorsRepository->update($model);
} catch (Exception $exception) {
    echo 'Something went wrong';
}

echo 'Success!' . PHP_EOL;
echo '<a href="../../doctors.php" class="add-doctor-button">Doctors list.</a>';
<?php

use RedBeanPHP\R;

require_once __DIR__ . '/../../../app/DataAccess/DoctorsRepository.php';
require_once __DIR__ . '/../../../app/DataAccess/SpecialtiesRepository.php';
require_once __DIR__ . '/../../../app/DataAccess/StatusesRepository.php';

require_once '../../../vendor/autoload.php';
require_once __DIR__ . '/../../../app/DataAccess/SpecialtiesRepository.php';

const DB_PATH = __DIR__ . '/../../../data/clinic.db';

$connectionString = 'sqlite:' . realpath(DB_PATH);

R::setup($connectionString);

$specialtiesRepository = new SpecialtiesRepository();
$statusesRepository = new StatusesRepository();

$specialties = $specialtiesRepository->getAll();
$statuses = $statusesRepository->getAll();

$id = $_POST['doctorId'];
$firstName = $_POST['firstName'];
$lastName = $_POST['firstName'];
$patronymic = $_POST['patronymic'];
$dateOfBirth = $_POST['dateOfBirth'];
$earning = $_POST['earningInPercents'];
$specialityId = $_POST['specialityId'];
$statusId = $_POST['statusId'];
$status = $_POST['status'];
$speciality = $_POST['speciality'];

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .form-field {
            width: 300px;
            height: 35px;
        }

        body {
            font-size: 30px;
        }
    </style>
</head>
<body>
<a href="../../doctors.php">Return back</a>
<h1>Edit doctor: <?= $firstName?></h1>
<form action="update-doctor-handler.php" method="post">
    <div class="form-box">
        <span>Specialty: </span>
        <label>
            <select style="width: 200px;" name="specialtyId" class="form-field">
                <option value=<?= $specialityId ?>>
                    <?= ucfirst($speciality) ?>
                </option>
                <?php foreach ($specialties as $specialty): ?>
                    <option value=<?= $specialty->id ?>>
                        <?= ucfirst($specialty->title) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
    </div>
    <div class="form-box">
        <span>Status: </span>
        <label>
            <select style="width: 200px;" name="statusId" class="form-field">
                <option value=<?= $statusId ?>>
                    <?= ucfirst($status) ?>
                </option>
                <?php foreach ($statuses as $status): ?>
                    <option value=<?= $status->id ?>>
                        <?= ucfirst($status->title) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
    </div>
    <div class="form-box">
        <label>
            <input type="text" name="doctorId" class="form-field" value="<?= $id ?>" hidden="true">
        </label>
    </div>
    <div class="form-box">
        <span>First Name: </span>
        <label>
            <input type="text" name="firstName" class="form-field" value="<?= $firstName ?>">
        </label>
    </div>
    <div class="form-box">
        <span>Last Name: </span>
        <label>
            <input type="text" name="lastName" class="form-field" value="<?= $lastName ?>">
        </label>
    </div>
    <div class="form-box">
        <span>Patronymic: </span>
        <label>
            <input type="text" name="patronymic" class="form-field" value="<?= $patronymic ?>">
        </label>
    </div>
    <div class="form-box">
        <span>Date of birth: </span>
        <label>
            <input type="text" name="dateOfBirth" class="form-field" value="<?= $dateOfBirth ?>">
        </label>
    </div>
    <div class="form-box">
        <span>Earning in percents: </span>
        <label>
            <input type="text" name="earningInPercents" class="form-field" value="<?= $earning ?>">
        </label>
    </div>
    <input type="submit">
</form>
</body>
</html>

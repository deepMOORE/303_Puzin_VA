<?php

require_once __DIR__ . '/../../../app/Connection.php';
require_once __DIR__ . '/../../../app/DataAccess/SpecialtiesRepository.php';

const DB_PATH = __DIR__ . '/../../../data/clinic.db';

$connection = Connection::sqlite3(DB_PATH);

$specialtiesRepository = new SpecialtiesRepository($connection);

$specialties = $specialtiesRepository->getAll();

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
<a href="../../index.php" class="add-doctor-button">Return back</a>
<form action="add-doctor-handler.php" method="post">
    <div class="form-box">
        <span>Specialty: </span>
        <label>
            <select style="width: 200px;" name="specialtyId" class="form-field">
                <option value=<?= null ?>>
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
        <span>First Name: </span>
        <label>
            <input type="text" name="firstName" class="form-field">
        </label>
    </div>
    <div class="form-box">
        <span>Last Name: </span>
        <label>
            <input type="text" name="lastName" class="form-field">
        </label>
    </div>
    <div class="form-box">
        <span>Patronymic: </span>
        <label>
            <input type="text" name="patronymic" class="form-field">
        </label>
    </div>
    <div class="form-box">
        <span>Date of birth: </span>
        <label>
            <input type="text" name="dateOfBirth" class="form-field" placeholder="2000-01-01">
        </label>
    </div>
    <div class="form-box">
        <span>Earning in percents: </span>
        <label>
            <input type="text" name="earningInPercents" class="form-field" placeholder="70">
        </label>
    </div>
    <input type="submit">
</form>
</body>
</html>

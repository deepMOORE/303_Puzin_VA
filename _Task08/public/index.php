<?php
require_once __DIR__ . '/../app/Connection.php';
require_once __DIR__ . '/../app/DataAccess/ReceptionsRepository.php';
require_once __DIR__ . '/../app/DataAccess/SpecialitiesRepository.php';
require_once __DIR__ . '/../app/DataAccess/DoctorsRepository.php';
require_once __DIR__ . '/../app/DataAccess/DoctorsRepository.php';
require_once __DIR__ . '/../app/Utils/ParametersValidator.php';

const DB_PATH = 'data/clinic.db';
const CURRENCY = 'RUB';

const DOCTOR_ID = 'doctorId';

$connection = Connection::sqlite3(DB_PATH);

$receptionsRepository = new ReceptionsRepository($connection);
$doctorsRepository = new DoctorsRepository($connection);
$specialityRepository = new SpecialitiesRepository($connection);

$doctorIds = $doctorsRepository->getAllIds();

$validator = new ParametersValidator();
$doctorId = null;
if(isset($_POST[DOCTOR_ID])){
    $doctorId = $validator->getInputParametersFromPost('doctorId');
    $validationResult = $validator->validate($doctorId);
}

$receptions = $doctorId === null || $doctorId === '' ?
    $receptionsRepository->getAll() :
    $receptionsRepository->getByDoctor((int)$doctorId);

$specialities = $specialityRepository->getAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        body {
            font-family: sans-serif;
        }
        .doctors-table {
            border: 1px solid black;
        }
        .table-header {
            border-bottom: 1px solid black;
        }

        .doctor-form {
            width: 550px;
        }

        .form-field {
            margin-bottom: 20px;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .input-field {
            padding: 0;
            width: 400px;
        }
    </style>
</head>
<body>
<h1>Please, select doctor's ID</h1>
<form action="" method="POST">
    <label>
        <select style="width: 200px;" name="doctorId">
            <option value=<?= null ?>>

            </option>
            <?php foreach($doctorIds as $doctorId): ?>
                <option value=<?= $doctorId->value ?>>
                    <?= $doctorId->value ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>
    <button type="submit">Search by ID</button>
</form>
<table class="doctors-table">
    <tr class="table-header">
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Patronymic</th>
        <th>Service name</th>
        <th>Status</th>
        <th>Ended at</th>
        <th>Price</th>
    </tr>
    <?php foreach($receptions as $reception): ?>
        <tr>
            <td><?= $reception->id ?></td>
            <td><?= $reception->firstName ?></td>
            <td><?= $reception->lastName ?></td>
            <td><?= $reception->patronymic ?></td>
            <td><?= $reception->serviceName ?></td>
            <td><?= $reception->status ?></td>
            <td><?= $reception->endedAt ?? 'Not ended yet' ?></td>
            <td><?= $reception->price . CURRENCY ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<h2>You can add doctor</h2>
<form class="doctor-form" action="add-doctor.php" method="post">
    <div class="form-field">
        <span>Speciality: </span>
        <label>
            <select class="input-field" name="speciality">
                <option value=<?= null ?>>

                </option>
                <?php foreach($specialities as $speciality): ?>
                    <option value=<?= $speciality->id ?>>
                        <?= ucfirst($speciality->title) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
    </div>
    <div class="form-field">
        <span>First Name: </span>
        <label>
            <input class="input-field" type="text" name="firstName">
        </label>
    </div>
    <div class="form-field">
        <span>Last Name: </span>
        <label>
            <input class="input-field" type="text" name="lastName">
        </label>
    </div>
    <div class="form-field">
        <span>Patronymic: </span>
        <label>
            <input class="input-field" type="text" name="patronymic">
        </label>
    </div>
    <div class="form-field">
        <span>Date of birth: </span>
        <label>
            <input class="input-field" type="text" name="dateOfBirth" placeholder="2000-01-01">
        </label>
    </div>
    <input type="submit" value="Create"/>
</form>
</body>
</html>
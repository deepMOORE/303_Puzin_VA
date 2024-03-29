<?php

require_once __DIR__ . '/../app/Connection.php';
require_once __DIR__ . '/../app/DataAccess/ReceptionsRepository.php';
require_once __DIR__ . '/../app/DataAccess/DoctorsRepository.php';
require_once __DIR__ . '/../app/Utils/ParametersValidator.php';

const DB_PATH = __DIR__ . '/../data/clinic.db';

$connection = Connection::sqlite3(DB_PATH);

$repository = new ReceptionsRepository($connection);
$receptionsRepository = new ReceptionsRepository($connection);
$doctorsRepository = new DoctorsRepository($connection);

$doctorIds = $doctorsRepository->getAllIds();

$validator = new ParametersValidator();
$doctorId = null;
if(isset($_POST['doctorId'])){
    $doctorId = $validator->getInputParametersFromPost('doctorId');
    $validationResult = $validator->validate($doctorId);
}

$receptions = $doctorId === null || $doctorId === '' ?
    $receptionsRepository->getAll() :
    $receptionsRepository->getByDoctor((int)$doctorId);

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        .doctors-table {
            border: 1px solid black;
        }

        .table-header {
            border-bottom: 1px solid black;
        }

        .add-doctor-button {
            font-size: 20px;
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
            <td><?= $reception->doctorFirstName ?></td>
            <td><?= $reception->doctorLastName ?></td>
            <td><?= $reception->doctorPatronymic ?></td>
            <td><?= $reception->serviceName ?></td>
            <td><?= $reception->status ?></td>
            <td><?= $reception->endedAt ?? 'Not ended yet' ?></td>
            <td><?= $reception->price . '$' ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<a href="forms/add-doctor/add-doctor-form.php" class="add-doctor-button">Add Doctor</a>
</body>
</html>

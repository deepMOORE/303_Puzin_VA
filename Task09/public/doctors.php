<?php

require_once __DIR__ . '/../app/Connection.php';
require_once __DIR__ . '/../app/DataAccess/DoctorsRepository.php';

const DB_PATH = __DIR__ . '/../data/clinic.db';

$connection = Connection::sqlite3(DB_PATH);

$doctorsRepository = new DoctorsRepository($connection);

$doctors = $doctorsRepository->getAll();

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
<h1>There is all doctors</h1>
<table class="doctors-table">
    <tr class="table-header">
        <th>First Name</th>
        <th>Last Name</th>
        <th>Patronymic</th>
        <th>Date of Birth</th>
        <th>Speciality</th>
        <th>Status</th>
        <th>Earning</th>
    </tr>
    <?php foreach ($doctors as $doctor): ?>
        <tr>
            <td><?= $doctor->firstName ?></td>
            <td><?= $doctor->lastName ?></td>
            <td><?= $doctor->patronymic ?></td>
            <td><?= $doctor->dateOfBirth ?></td>
            <td><?= $doctor->speciality ?></td>
            <td><?= $doctor->employeeStatus ?></td>
            <td><?= $doctor->earningInPercents . '%' ?></td>
            <td>
                <form action="forms/delete-doctor/delete-doctor-handler.php" method="post">
                    <input type="text" value="<?= $doctor->id ?>" hidden="true" name="doctorId">
                    <input style="background-color: red" type="submit" value="Delete">
                </form>
            </td>
            <td>
                <form action="forms/update-doctor/update-doctor-form.php" method="post">
                    <input type="text" value="<?= $doctor->id ?>" hidden="true" name="doctorId">
                    <input type="text" value="<?= $doctor->firstName ?>" hidden="true" name="firstName">
                    <input type="text" value="<?= $doctor->lastName ?>" hidden="true" name="lastName">
                    <input type="text" value="<?= $doctor->patronymic ?>" hidden="true" name="patronymic">
                    <input type="text" value="<?= $doctor->dateOfBirth ?>" hidden="true" name="dateOfBirth">
                    <input type="text" value="<?= $doctor->employeeStatus ?>" hidden="true" name="employeeStatus">
                    <input type="text" value="<?= $doctor->earningInPercents ?>" hidden="true" name="earningInPercents">
                    <input type="text" value="<?= $doctor->specialityId ?>" hidden="true" name="specialityId">
                    <input type="text" value="<?= $doctor->statusId ?>" hidden="true" name="statusId">
                    <input type="text" value="<?= $doctor->speciality ?>" hidden="true" name="speciality">
                    <input type="text" value="<?= $doctor->employeeStatus ?>" hidden="true" name="status">
                    <input style="background-color: coral" type="submit" value="Edit">
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<a href="forms/add-doctor/add-doctor-form.php" class="add-doctor-button">Add Doctor</a>
</body>
</html>

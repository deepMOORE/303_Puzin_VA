<?php declare(strict_types=1);

require_once __DIR__ . '/../../../app/Connection.php';
require_once __DIR__ . '/../../../app/DataAccess/DoctorsRepository.php';

const DB_PATH = __DIR__ . '/../../../data/clinic.db';

$connection = Connection::sqlite3(DB_PATH);

$doctorsRepository = new DoctorsRepository($connection);

$id = (int)$_POST['doctorId'];

$doctorsRepository->deleteById($id);

echo 'Success!'. PHP_EOL;
echo '<a href="../../doctors.php" class="add-doctor-button">Choose another one to delete.</a>';

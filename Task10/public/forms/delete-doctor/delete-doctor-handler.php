<?php declare(strict_types=1);

require_once '../../../vendor/autoload.php';
require_once __DIR__ . '/../../../app/Connection.php';
require_once __DIR__ . '/../../../app/DataAccess/DoctorsRepository.php';

use RedBeanPHP\R;

const DB_PATH = __DIR__ . '/../data/clinic.db';

$connectionString = 'sqlite:' . realpath(DB_PATH);

R::setup($connectionString);

$id = (int)$_POST['doctorId'];

$doctorsRepository = new DoctorsRepository();

$doctorsRepository->deleteById($id);

echo 'Success!'. PHP_EOL;
echo '<a href="../../doctors.php" class="add-doctor-button">Choose another one to delete.</a>';

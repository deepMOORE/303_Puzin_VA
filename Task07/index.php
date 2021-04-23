<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<?php
require_once 'Connection.php';
require_once 'DataAccess/ReceptionsRepository.php';
require_once 'DataAccess/Repository.php';
require_once 'DataAccess/DoctorsRepository.php';
require_once 'Mappers/ReceptionsMapper.php';
require_once 'Mappers/DoctorsMapper.php';
require_once 'Utils/ParametersValidator.php';

const INIT_COMMAND = 'init';
const DB_NAME = 'clinic.db';
const CURRENCY = 'RUB';

shell_exec(INIT_COMMAND);

$connection = Connection::sqlite3(DB_NAME);

$receptionsRepository = new ReceptionsRepository($connection);
$doctorsRepository = new DoctorsRepository($connection);
$receptionsMapper = new ReceptionsMapper();
$doctorsMapper = new DoctorsMapper();

$doctorIds = $doctorsMapper->extractIds($doctorsRepository->getAllIds());

?>
<h1>Please, select doctor's ID</h1>
<form action="" method="POST">
    <label>
        <select style="width: 200px;" name="doctorId">
            <option value=<?= null ?>>

            </option>
            <?php foreach($doctorIds as $id): ?>
                <option value=<?= $id ?>>
                    <?= $id ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>
    <button type="submit">Search by ID</button>
</form>
<?php
$validator = new ParametersValidator();
$doctorId = null;
if(isset($_POST['doctorId'])){
    $doctorId = $validator->getInputParametersFromPost('doctorId');
    $validationResult = $validator->validate($doctorId);
}

$rawData = $doctorId === null || $doctorId === '' ?
    $receptionsRepository->getAll() :
    $receptionsRepository->getByDoctor((int)$doctorId);

$receptions = $mapper->map($rawData);
?>

<?php if (count($receptions) < 1): ?>
    No receptions for this doctor yet
<?php endif; ?>
</body>
</html>
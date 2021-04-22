<?php declare(strict_types=1);

require_once 'Connection.php';
require_once 'DataAccess/ReceptionsRepository.php';
require_once 'DataAccess/Repository.php';
require_once 'Mappers/ReceptionsMapper.php';
require_once 'ParametersValidator.php';

const INIT_COMMAND = 'init';
const DB_NAME = 'movies_rating.db';
const CURRENCY = 'RUB';

shell_exec(INIT_COMMAND);

$validator = new ParametersValidator();
$doctorId = $validator->getInputParameters();
$validationResult = $validator->validate($doctorId);

if (!$validationResult->success) {
    lineError($validationResult->message ?? 'Something is wrong');
    die();
}

$connection = Connection::sqlite3(DB_NAME);

$receptionsRepository = new ReceptionsRepository($connection);
$mapper = new ReceptionsMapper();

$rawData = $doctorId === null ?
    $receptionsRepository->getAll() :
    $receptionsRepository->getByDoctor((int)$doctorId);

$receptions = $mapper->map($rawData);

if (count($receptions) < 1) {
    echo 'No receptions for this doctor yet';
    die();
}

foreach ($receptions as $reception) {
    line();
    lineWithFields(
        '  ',
        $reception->doctor->id,
        $reception->doctor->firstName,
        $reception->doctor->lastName,
        $reception->doctor->patronymic,
        $reception->serviceName,
        $reception->endedAt ?? 'Not ended yet',
        $reception->price . CURRENCY,
        $reception->status,
        PHP_EOL
    );
}
line();

function line(): void
{
    echo '------------------------------------------------------------------------------------' . PHP_EOL;
}

function lineWithFields(string $glue, ...$parameters): void
{
    echo implode($glue, $parameters);
}

function lineError(string $message): void
{
    echo "Error: $message";
}

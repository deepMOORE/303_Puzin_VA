<?php declare(strict_types=1);

require_once 'Connection.php';
require_once 'DataAccess/ReceptionsRepository.php';
require_once 'DataAccess/Repository.php';
require_once 'Mappers/ReceptionsMapper.php';
require_once 'Utils/ParametersValidator.php';
require_once 'Utils/ConsoleWriter.php';

const INIT_COMMAND = 'init';
const DB_NAME = 'clinic.db';
const CURRENCY = 'RUB';

shell_exec(INIT_COMMAND);

$validator = new ParametersValidator();
$doctorId = $validator->getInputParameters();
$validationResult = $validator->validate($doctorId);

if (!$validationResult->success) {
    $output->lineError($validationResult->message ?? 'Something is wrong');
    die();
}

$connection = Connection::sqlite3(DB_NAME);

$receptionsRepository = new ReceptionsRepository($connection);
$mapper = new ReceptionsMapper();
$output = new ConsoleWriter();

$rawData = $doctorId === null ?
    $receptionsRepository->getAll() :
    $receptionsRepository->getByDoctor((int)$doctorId);

$receptions = $mapper->map($rawData);

if (count($receptions) < 1) {
    $output->message('No receptions for this doctor yet');
    die();
}

foreach ($receptions as $reception) {
    $output->line();
    $output->lineWithFields(
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
$output->line();


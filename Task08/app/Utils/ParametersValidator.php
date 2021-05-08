<?php declare(strict_types=1);

require_once __DIR__ . '/../Models/ValidationResult.php';

class ParametersValidator
{
    //todo: здесь должна быть сложная валидация по любым именам параметров и их типов, но пока что достаточно первогоб и
    //todo: и вообще этот метод не дооден здесь находится
    public function getInputParametersFromGlobals(): ?string
    {
        return $GLOBALS['argv'][1] ?? null;
    }

    public function getInputParametersFromPost(string $name)
    {
        return $_POST[$name];
    }

    public function validate($parameter): ValidationResult
    {
        if ($parameter === null || $parameter === '') {
            return ValidationResult::success();
        }

        if (!is_numeric($parameter)) {
            return ValidationResult::fail('Doctor ID must be a number.');
        }

        if ($parameter < 1) {
            return ValidationResult::fail('Doctor ID must be a positive number greater then 0.');
        }

        return ValidationResult::success();
    }
}

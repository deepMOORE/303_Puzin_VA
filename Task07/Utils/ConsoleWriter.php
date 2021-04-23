<?php declare(strict_types=1);

class ConsoleWriter
{
    public function message(string $message): void
    {
        echo $message;
    }

    public function line(): void
    {
        echo '------------------------------------------------------------------------------------' . PHP_EOL;
    }

    public function lineWithFields(string $glue, ...$parameters): void
    {
        echo implode($glue, $parameters);
    }

    public function lineError(string $message): void
    {
        echo "Error: $message";
    }
}

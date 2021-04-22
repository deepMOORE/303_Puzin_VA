<?php declare(strict_types=1);

class DoctorShortModel
{
    public int $id;

    public string $firstName;

    public string $lastName;

    public ?string $patronymic;

    public function __construct(int $id, string $firstName, string $lastName, ?string $patronymic)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->patronymic = $patronymic;
    }
}

<?php declare(strict_types=1);

class DoctorCreateModel
{
    public int $specialtyId;
    public string $firstName;
    public string $lastName;
    public string $patronymic;
    public int $earningInPercents;
    public DateTime $dateOfBirth;

    public function __construct(int $specialtyId, string $firstName, string $lastName, string $patronymic, int $earningInPercents, DateTime $dateOfBirth)
    {
        $this->specialtyId = $specialtyId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->patronymic = $patronymic;
        $this->earningInPercents = $earningInPercents;
        $this->dateOfBirth = $dateOfBirth;
    }
}

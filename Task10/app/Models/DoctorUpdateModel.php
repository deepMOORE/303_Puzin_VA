<?php declare(strict_types=1);

class DoctorUpdateModel
{
    public int $id;
    public int $specialtyId;
    public string $firstName;
    public string $lastName;
    public string $patronymic;
    public int $earningInPercents;
    public DateTime $dateOfBirth;
    public int $statusId;

    public function __construct(int $id, int $specialtyId, string $firstName, string $lastName, string $patronymic, int $earningInPercents, DateTime $dateOfBirth, int $statusId)
    {
        $this->id = $id;
        $this->specialtyId = $specialtyId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->patronymic = $patronymic;
        $this->earningInPercents = $earningInPercents;
        $this->dateOfBirth = $dateOfBirth;
        $this->statusId = $statusId;
    }
}

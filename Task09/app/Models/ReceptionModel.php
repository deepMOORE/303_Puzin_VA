<?php declare(strict_types=1);

class ReceptionModel
{
    public int $id;

    public string $doctorFirstName;

    public string $doctorLastName;

    public ?string $doctorPatronymic;

    public string $serviceName;

    public string $status;

    public ?string $endedAt;

    public float $price;
}

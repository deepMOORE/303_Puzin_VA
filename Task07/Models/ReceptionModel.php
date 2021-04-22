<?php declare(strict_types=1);

require_once 'Models/DoctorShortModel.php';

class ReceptionModel
{
    public DoctorShortModel $doctor;

    public string $serviceName;

    public string $status;

    public ?string $endedAt;

    public float $price;

    public function __construct(DoctorShortModel $doctor, string $serviceName, string $status, ?string $endedAt, float $price)
    {
        $this->doctor = $doctor;
        $this->serviceName = $serviceName;
        $this->status = $status;
        $this->endedAt = $endedAt;
        $this->price = $price;
    }
}

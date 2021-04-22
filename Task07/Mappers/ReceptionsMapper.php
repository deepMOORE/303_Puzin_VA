<?php declare(strict_types=1);

require_once 'Models/DoctorShortModel.php';
require_once 'Models/ReceptionModel.php';

class ReceptionsMapper
{
    /**
     * @param object[] $data
     * @return ReceptionModel[]
     */
    public function map(array $data): array
    {
        return array_map(static function ($x) {
            $doctor = new DoctorShortModel(
                (int)$x->id,
                $x->firstName,
                $x->lastName,
                $x->patronymic
            );

            return new ReceptionModel(
                $doctor,
                $x->serviceName,
                $x->status,
                $x->endedAt,
                (float)$x->price
            );
        }, $data);
    }
}

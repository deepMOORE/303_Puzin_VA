<?php declare(strict_types=1);

require_once __DIR__ . '/Repository.php';
require_once __DIR__ . '/../Models/DoctorIdModel.php';
require_once __DIR__ . '/../Models/DoctorCreateModel.php';

class DoctorsRepository extends Repository
{
    public function create(DoctorCreateModel $model): int
    {
        $connection = $this->getConnection();

        $connection->beginTransaction();

        $query = $connection
            ->prepare('
insert into doctors (first_name, last_name, patronymic, date_of_birth, speciality_id, earning_in_percents, employee_status_id)
VALUES (?, ?, ?, ?, ?, ?, ?)');

        $query->execute([
            $model->firstName,
            $model->lastName,
            $model->patronymic,
            $model->dateOfBirth->format('Y-m-d'),
            $model->specialtyId,
            $model->earningInPercents,
            1 // work
        ]);

        $doctorId = $connection->lastInsertId();

        $connection->commit();

        return (int)$doctorId;
    }

    /**
     * @return DoctorIdModel[]
     */
    public function getAllIds(): array
    {
        return $this->getConnection()
            ->query(
                '
select d.id as value   
from doctors as d'
            )
            ->fetchAll(PDO::FETCH_CLASS, DoctorIdModel::class);
    }
}

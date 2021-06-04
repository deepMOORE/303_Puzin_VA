<?php declare(strict_types=1);

require_once __DIR__ . '/Repository.php';
require_once __DIR__ . '/../Models/DoctorIdModel.php';
require_once __DIR__ . '/../Models/DoctorFullModel.php';
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

    public function update(DoctorUpdateModel $model): void
    {
        $connection = $this->getConnection();

        $query = $connection
            ->prepare('
update doctors
set first_name = ?,
    last_name = ?,
    patronymic = ?,
    date_of_birth = ?,
    speciality_id = ?,
    employee_status_id = ?,
    earning_in_percents = ?
where id = ?');

        $query->execute([
            $model->firstName,
            $model->lastName,
            $model->patronymic,
            $model->dateOfBirth->format('Y-m-d'),
            $model->specialtyId,
            $model->statusId,
            $model->earningInPercents,
            $model->id
        ]);
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

    /**
     * @return DoctorFullModel[]
     */
    public function getAll(): array
    {
        return $this->getConnection()
            ->query(
                '
select d.id                  as id,
       d.first_name          as firstName,
       d.last_name           as lastName,
       d.patronymic          as patronymic,
       d.date_of_birth       as dateOfBirth,
       d.earning_in_percents as earningInPercents,
       s.title               as speciality,
       d.speciality_id       as specialityId,
       es.title              as employeeStatus,
       es.id                 as statusId
from doctors as d
         join specialties s on d.speciality_id = s.id
         join employee_statuses es on d.employee_status_id = es.id'
            )
            ->fetchAll(PDO::FETCH_CLASS, DoctorFullModel::class);
    }

    public function deleteById(int $id): void
    {
        $query = $this->getConnection()
            ->prepare('
delete from doctors where id = ?
            ');

        $query->execute([
            $id,
        ]);
    }
}

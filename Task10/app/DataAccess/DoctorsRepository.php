<?php declare(strict_types=1);

use RedBeanPHP\R;

require_once __DIR__ . '/../Models/DoctorIdModel.php';
require_once __DIR__ . '/../Models/DoctorFullModel.php';
require_once __DIR__ . '/../Models/DoctorCreateModel.php';

class DoctorsRepository
{
    public function create(DoctorCreateModel $model): int
    {
        $doctor = R::dispense('doctors');
        $doctor->first_name = $model->firstName;
        $doctor->last_name = $model->lastName;
        $doctor->patronymic = $model->patronymic;
        $doctor->date_of_birth = $model->dateOfBirth;
        $doctor->speciality_id = $model->specialtyId;
        $doctor->earning_in_percents = $model->earningInPercents;
        $doctor->employee_status_id = 1; // new

        return R::store($doctor);
    }

    public function update(DoctorUpdateModel $model): void
    {
        $toUpdate = R::load('doctors', $model->id);
        $toUpdate->first_name = $model->firstName;
        $toUpdate->last_name = $model->lastName;
        $toUpdate->patronymic = $model->patronymic;
        $toUpdate->date_of_birth = $model->dateOfBirth;
        $toUpdate->speciality_id = $model->specialtyId;
        $toUpdate->status_id = $model->statusId;
        $toUpdate->earning_in_percents = $model->earningInPercents;
        R::store($toUpdate);
    }

    /**
     * @return DoctorIdModel[]
     */
    public function getAllIds(): array
    {
        $models = R::findAll('doctors');

        return array_map(
            static function ($x) {
                $id = new DoctorIdModel();
                $id->value = (int)$x->id;

                return $id;
            },
            $models
        );
    }

    /**
     * @return DoctorFullModel[]
     */
    public function getAll(): array
    {
        $sql = '
select d.id,
       d.first_name,
       d.last_name,
       d.patronymic,
       d.date_of_birth,
       d.earning_in_percents,
       s.title as specialty,
       d.speciality_id,
       es.title,
       es.id as statusId
from doctors as d
         join specialties s on d.speciality_id = s.id
         join employee_statuses es on d.employee_status_id = es.id';

        $rows = R::getAll($sql);
        $receptions = R::convertToBeans('doctors', $rows);

        return array_map(
            static function ($x) {
                $model = new DoctorFullModel();
                $model->id = (int)$x->id;
                $model->firstName = $x->first_name;
                $model->lastName = $x->last_name;
                $model->patronymic = $x->patronymic;
                $model->dateOfBirth = $x->date_of_birth;
                $model->earningInPercents = (int)$x->earning_in_percents;
                $model->speciality = $x->specialty;
                $model->statusId = (int)$x->statusId;
                $model->employeeStatus = $x->title;
                $model->specialityId = (int)$x->speciality_id;

                return $model;
            },
            $receptions
        );
    }

    public function deleteById(int $id): void
    {
        R::trash('doctors', $id);
    }
}

<?php declare(strict_types=1);

use RedBeanPHP\R;

require_once __DIR__ . '/../Models/ReceptionModel.php';

class ReceptionsRepository
{
    public function getAll(): array
    {
        $sql = '
select d.id,
       d.first_name,
       d.last_name,
       d.patronymic,
       r.ended_at,
       rs.title as reception_title,
       s.title  as status_title,
       s.price

from receptions as r
         join doctors as d on r.doctor_id = d.id
         join services as s on r.service_id = s.id
         join reception_statuses rs on r.status_id = rs.id';

        $rows = R::getAll($sql);
        $receptions = R::convertToBeans('receptions', $rows);

        return array_map(
            $this->getMapFn(),
            $receptions
        );
    }

    /**
     * @param int $doctorId
     * @return ReceptionModel[]
     */
    public function getByDoctor(int $doctorId): array
    {
        $sql = "
select d.id,
       d.first_name,
       d.last_name,
       d.patronymic,
       r.ended_at,
       rs.title as reception_title,
       s.title  as status_title,
       s.price

from receptions as r
         join doctors as d on r.doctor_id = d.id
         join services as s on r.service_id = s.id
         join reception_statuses rs on r.status_id = rs.id
where d.id = $doctorId";

        $rows = R::getAll($sql);
        $receptions = R::convertToBeans('receptions', $rows);

        return array_map(
            $this->getMapFn(),
            $receptions
        );
    }

    private function getMapFn(): Closure
    {
        return static function ($x) {
            $model = new ReceptionModel();
            $model->id = (int)$x->id;
            $model->doctorFirstName = $x->first_name;
            $model->doctorLastName = $x->last_name;
            $model->doctorPatronymic = $x->patronymic;
            $model->endedAt = $x->ended_at;
            $model->serviceName = $x->reception_title;
            $model->status = $x->status_title;
            $model->price = (float)$x->price;

            return $model;
        };
    }
}

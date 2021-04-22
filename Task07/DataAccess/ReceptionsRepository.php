<?php declare(strict_types=1);

require_once 'Repository.php';

class ReceptionsRepository extends Repository
{
    /**
     * @return object[]
     */
    public function getAll(): array
    {
        return $this->getConnection()
            ->query(
                '
select d.id         as id,
       d.first_name as firstName,
       d.last_name  as lastName,
       d.patronymic as patronymic,
       r.ended_at   as endedAt,
       rs.title     as serviceName,
       s.title      as status,
       s.price      as price

from receptions as r
         join doctors as d on r.doctor_id = d.id
         join services as s on r.service_id = s.id
         join reception_statuses rs on r.status_id = rs.id'
            )
            ->fetchAll(PDO::FETCH_OBJ);
    }

    public function getByDoctor(int $doctorId): array
    {
        $statement = $this->getConnection()
            ->prepare(
                '
select d.id         as id,
       d.first_name as firstName,
       d.last_name  as lastName,
       d.patronymic as patronymic,
       r.ended_at   as endedAt,
       rs.title     as serviceName,
       s.title      as status,
       s.price      as price

from receptions as r
         join doctors as d on r.doctor_id = d.id
         join services as s on r.service_id = s.id
         join reception_statuses rs on r.status_id = rs.id
where d.id = ?'
            );

        $statement->execute([$doctorId]);

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }
}

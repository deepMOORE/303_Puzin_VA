<?php declare(strict_types=1);

require_once __DIR__ . '/Repository.php';
require_once __DIR__ . '/../Models/SpecialtyModel.php';

class SpecialtiesRepository extends Repository
{
    /**
     * @return SpecialtyModel[]
     */
    public function getAll(): array
    {
        return $this->getConnection()
            ->query(
                '
select s.id as id, s.title as title   
from specialties as s'
            )
            ->fetchAll(PDO::FETCH_CLASS, SpecialtyModel::class);
    }
}

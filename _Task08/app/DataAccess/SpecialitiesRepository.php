<?php declare(strict_types=1);

require_once __DIR__ . '/Repository.php';
require_once __DIR__ . '/../Models/SpecialityModel.php';

class SpecialitiesRepository extends Repository
{
    /**
     * @return SpecialityModel[]
     */
    public function getAll(): array
    {
        return $this->getConnection()
            ->query(
                '
select id, title
from specialties;'
            )
            ->fetchAll(PDO::FETCH_CLASS, SpecialityModel::class);
    }
}

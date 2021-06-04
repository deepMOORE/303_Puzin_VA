<?php declare(strict_types=1);

require_once __DIR__ . '/Repository.php';
require_once __DIR__ . '/../Models/StatusModel.php';

class StatusesRepository extends Repository
{
    /**
     * @return StatusModel[]
     */
    public function getAll(): array
    {
        return $this->getConnection()
            ->query(
                '
select s.id as id,
       s.title as title   
from employee_statuses as s'
            )
            ->fetchAll(PDO::FETCH_CLASS, StatusModel::class);
    }
}

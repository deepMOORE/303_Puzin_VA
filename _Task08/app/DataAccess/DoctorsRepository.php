<?php declare(strict_types=1);

require_once __DIR__ . '/../Models/DoctorIdModel.php';

class DoctorsRepository extends Repository
{
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

<?php declare(strict_types=1);

class DoctorsRepository extends Repository
{
    /**
     * @return object[]
     */
    public function getAllIds(): array
    {
        return $this->getConnection()
            ->query(
                '
select d.id as doctorId   
from doctors as d'
            )
            ->fetchAll(PDO::FETCH_OBJ);
    }
}

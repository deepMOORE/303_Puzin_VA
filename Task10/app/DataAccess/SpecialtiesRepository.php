<?php declare(strict_types=1);

use RedBeanPHP\R;

require_once __DIR__ . '/../Models/SpecialtyModel.php';

class SpecialtiesRepository
{
    /**
     * @return SpecialtyModel[]
     */
    public function getAll(): array
    {
        $sql = '
select s.id as id, s.title as title   
from specialties as s';

        $rows = R::getAll($sql);
        $models = R::convertToBeans('specialties', $rows);

        return array_map(
            static function ($x) {
                $model = new SpecialtyModel();
                $model->id = (int)$x->id;
                $model->title = $x->title;

                return $model;
            },
            $models
        );
    }
}

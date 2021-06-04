<?php declare(strict_types=1);

use RedBeanPHP\R;

require_once __DIR__ . '/../Models/StatusModel.php';

class StatusesRepository
{
    /**
     * @return StatusModel[]
     */
    public function getAll(): array
    {
        $models = R::findAll('employee_statuses');

        return array_map(
            static function ($x) {
                $model = new StatusModel();
                $model->id = $x->id;
                $model->title = $x->title;

                return $model;
            },
            $models
        );
    }
}

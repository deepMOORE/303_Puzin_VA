<?php declare(strict_types=1);

class DoctorsMapper
{
    public function extractIds(array $data): array
    {
        return array_map(static function ($x) {
            return (int)$x->doctorId;
        }, $data);
    }
}

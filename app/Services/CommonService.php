<?php
namespace App\Services;
abstract class CommonService
{
    public function getAll()
    {
        return $this->connection()->query()->get();
    }

    public function insert(array $data)
    {
        return $this->connection()->query()->create($data);
    }

    public function getById($id)
    {
        return $this->connection()->query()->where('', $id)->first();
    }


    abstract public function connection();
}
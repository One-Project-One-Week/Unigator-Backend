<?php

namespace App\Services;

use App\Models\Category;

class CategoryService extends CommonService
{
    public function connection()
    {
        return new Category;
    }

    public function getDataById($id)
    {
        return $this->connection()->query()->where('id', $id)->firstOrFail();
    }

    public function createData(array $data)
    {
        return $this->connection()->query()->create($data);
    }

    public function updateData(array $data, $id)
    {
        return $this->connection()->query()->where('id', $id)->update($data);
    }

    public function deleteData($id)
    {
        return $this->connection()->query()->where('id', $id)->delete();
    }
}
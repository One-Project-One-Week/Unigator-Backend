<?php

namespace App\Services;

use App\Models\Program;

class ProgramService extends CommonService
{
    public function connection()
    {
        return new Program;
    }

    public function getData()
    {
        return $this->connection()->with('category')->get();
    }

    public function getDataById($id)
    {
        return $this->connection()->query()->where('uuid', $id)->firstOrFail();
    }

    public function createData(array $data)
    {
        return $this->connection()->create($data);
    }

    public function updateData($id, array $data)
    {
        return $this->connection()->query()->where('uuid', $id)->update($data);
    }

    public function deleteData($id)
    {
        return $this->connection()->query()->where('uuid', $id)->delete();
    }
}
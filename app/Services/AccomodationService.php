<?php

namespace App\Services;

use App\Models\Accomodation;

class AccomodationService extends CommonService
{
    public function connection()
    {
        return new Accomodation;
    }

    public function getDataById($id)
    {
        return $this->connection()->query()->where('id', $id)->get();
    }

    public function createData(array $data)
    {
        return $this->connection()->create($data);
    }

    public function updateData($id, array $data)
    {
        return $this->connection()->query()->where('id', $id)->update($data);
    }

    public function deleteData($id)
    {
        return $this->connection()->query()->where('id', $id)->delete();
    }
}
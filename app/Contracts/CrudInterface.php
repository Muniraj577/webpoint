<?php

namespace App\Contracts;

interface CrudInterface
{
    public function getAll();

    public function save($data);

    public function getById($id);

    public function find($id);

    public function update($data, $id);

    public function delete($id);
}

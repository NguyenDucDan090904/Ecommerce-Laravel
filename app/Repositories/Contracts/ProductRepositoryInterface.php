<?php

namespace App\Repositories\Contracts;

interface ProductRepositoryInterface
{
    public function getAllPaginated(int $perPage = 10);
    public function findById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function insertWithAttributes(array $productData);
    public function toggleStatus($id);
    public function getActiveProducts($perPage = 12);
}

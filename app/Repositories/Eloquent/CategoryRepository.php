<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAll() { return Category::latest()->withCount('products')->paginate(10); }
    public function findById(int $id) { return Category::findOrFail($id); }
    public function create(array $data) { return Category::create($data); }

    public function update(int $id, array $data)
    {
        $category = $this->findById($id);
        $category->update($data);
        return $category;
    }

    public function delete(int $id)
    {
        $category = $this->findById($id);
        return $category->delete();
    }
}

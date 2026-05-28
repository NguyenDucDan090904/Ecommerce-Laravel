<?php

namespace App\Services;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Support\Str;

class CategoryService
{
    protected $categoryRepo;

    public function __construct(CategoryRepositoryInterface $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    public function storeCategory(array $data)
    {
        // Tự động tạo slug từ name trước khi lưu
        $data['slug'] = Str::slug($data['name']);
        return $this->categoryRepo->create($data);
    }

    public function updateCategory(int $id, array $data)
    {
        $data['slug'] = Str::slug($data['name']);
        return $this->categoryRepo->update($id, $data);
    }

    public function deleteCategory(int $id)
    {
        // Có thể thêm logic kiểm tra danh mục có sản phẩm không trước khi xóa tại đây
        return $this->categoryRepo->delete($id);
    }
}

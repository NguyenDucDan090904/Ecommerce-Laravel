<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAllPaginated(int $perPage = 10)
    {
        return Product::with(['category', 'images'])->latest()->paginate($perPage);
    }

    public function findById(int $id)
    {
        return Product::with('images')->findOrFail($id);
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update(int $id, array $data)
    {
        $product = Product::findOrFail($id);
        $product->update($data);
        return $product;
    }

    public function addImage($product, $path)
    {
        return $product->images()->create([
            'path' => $path
        ]);
    }

    public function delete(int $id)
    {
        $product = $this->findById($id);
        return $product->delete();
    }

    public function insertWithAttributes(array $productData)
    {
        // Tạo sản phẩm và tự động chuyển mảng attributes thành JSON nhờ Eloquent Casts
        return Product::create($productData);
    }

    public function getProductsForAdmin(array $filters = [])
    {
        $query = Product::with('images', 'category'); // Load sẵn quan hệ để tránh lỗi N+1

        // 1. Nếu có nhập từ khóa (keyword) -> Lọc theo tên sản phẩm
        if (!empty($filters['keyword'])) {
            $query->where('name', 'like', '%' . $filters['keyword'] . '%');
        }

        // 2. Nếu có chọn danh mục -> Lọc theo category_id
        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        // Trả về kết quả phân trang, nhớ dùng withQueryString() để chuyển trang không bị rớt bộ lọc
        return $query->latest('id')->paginate(10)->withQueryString();
    }

    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);

        // Đảo ngược trạng thái hiện tại (Đang 1 thành 0, đang 0 thành 1)
        $product->is_active = !$product->is_active;
        $product->save();

        return $product;
    }

    public function getActiveProducts($perPage = 12)
    {
        return Product::with(['images', 'category'])
            ->where('is_active', 1)
            ->latest('id')
            ->paginate($perPage);
    }
}

<?php

namespace App\Services;

use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use App\Models\ProductImage;

class ProductService
{
    protected $productRepo;

    public function __construct(ProductRepositoryInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function storeProduct(array $data, $images = null)
    {
        $product = $this->productRepo->create($data);
        $this->handleUploadImages($product, $images);
        return $product;
    }

    public function updateProduct(int $id, array $data, $images = null)
    {
        $product = $this->productRepo->update($id, $data);
        $this->handleUploadImages($product, $images);
        return $product;
    }

    public function deleteProduct(int $id)
    {
        $product = $this->productRepo->findById($id);

        // Xóa ảnh vật lý trên ổ cứng trước khi xóa product
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        return $this->productRepo->delete($id);
    }

    public function deleteSingleImage(int $imageId)
    {
        $image = ProductImage::findOrFail($imageId);
        Storage::disk('public')->delete($image->path);
        return $image->delete();
    }

    protected function handleUploadImages($product, $images)
    {
        if ($images) {
            foreach ($images as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create(['path' => $path]);
            }
        }
    }
}

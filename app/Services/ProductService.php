<?php

namespace App\Services;

use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use App\Models\ProductImage;
use Illuminate\Support\Str;

class ProductService
{
    protected $productRepo;

    public function __construct(ProductRepositoryInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function storeProduct(array $data)
    {
        // 1. Tạo slug tự động từ tên sản phẩm để tránh lỗi "missing slug"
        $slug = Str::slug($data['name']);

        // 2. KIỂM TRA & GỘP TỒN KHO: Xem sản phẩm đã tồn tại trong DB chưa
        $existingProduct = \App\Models\Product::where('slug', $slug)->first();

        if ($existingProduct) {
            // Nếu ĐÃ CÓ: Chỉ cộng dồn số lượng tồn kho và lưu lại
            $existingProduct->stock += (int) $data['stock'];

            // (Tùy chọn) Cập nhật lại giá nếu có thay đổi: $existingProduct->price = $data['price'];

            $existingProduct->save();

            return $existingProduct; // Trả về để Controller xử lý tiếp (ví dụ up ảnh)
        }

        // 3. Nếu CHƯA CÓ: Gắn thêm slug vào mảng data và tạo mới hoàn toàn
        $data['slug'] = $slug;

        // Lưu ý: Nếu $data chưa có mảng 'attributes', bạn gom nhóm giống hàm update nhé
        // Nhưng theo log SQL của bạn thì attributes đã được tạo chuẩn rồi.

        return $this->productRepo->create($data);
    }

    public function updateProduct(int $id, array $data, $images = null)
    {
        // 1. Cập nhật thông tin text (Service gọi Repo)
        $product = $this->productRepo->update($id, $data);

        // 2. Xử lý logic upload và lưu mảng ảnh
        if ($images) {
            foreach ($images as $file) {
                // Tạo tên file an toàn
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                // Lưu vào storage
                $path = $file->storeAs('products', $filename, 'public');

                // Gọi Repo để lưu đường dẫn vào DB (Không dùng Product:: ở đây)
                $this->productRepo->addImage($product, $path);
            }
        }

        $productData = [
            'name'        => $data['name'],
            'slug'        => Str::slug($data['name']),
            'category_id' => (int)$data['category_id'],
            'price'       => (float)$data['price'],
            'stock'       => (int)$data['stock'],
            'description' => $data['description'] ?? null,
            'attributes'  => [
                'battery' => $data['battery'] ?? null,
                'cpu'     => $data['cpu'] ?? null,
                'ram'     => $data['ram'] ?? null,
                'screen'  => $data['screen'] ?? null,
            ],
        ];

        // Nếu có ảnh mới đẩy từ Controller sang, thêm vào mảng để update
        if (isset($data['image'])) {
            $productData['image'] = $data['image'];
        }

        return $this->productRepo->update($id, $productData);
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

    public function importFromCsv($file)
    {
        $filePath = $file->getRealPath();
        $fileHandle = fopen($filePath, 'r');

        // Bỏ qua dòng tiêu đề đầu tiên (Header)
        fgetcsv($fileHandle, 0, ',');

        $importedCount = 0;

        while (($row = fgetcsv($fileHandle, 0, ',')) !== FALSE) {
            // Kiểm tra số lượng cột tối thiểu (ít nhất phải có thông tin cơ bản)
            if (count($row) < 5) continue;

            $productData = [
                'name'        => $row[0],
                'slug'        => Str::slug($row[0]),
                'category_id' => (int)$row[1],
                'price'       => (float)$row[2],
                'stock'       => (int)$row[3],
                // Gom tất cả thông số kỹ thuật vào mảng attributes JSON
                'attributes'  => [
                    'battery' => $row[4] ?? null,
                    'cpu'     => $row[5] ?? null,
                    'ram'     => $row[6] ?? null,
                    'screen'  => $row[7] ?? null,
                ],
                // Đẩy cột mô tả ra phía sau (Cột số 9 trong file, index là 8)
                'description' => $row[8] ?? null,
            ];

            $this->productRepo->create($productData);
            $importedCount++;
        }

        fclose($fileHandle);
        return $importedCount;
    }

    public function getProductsForAdmin(array $filters = [])
    {
        // Ở đây Service không tự query mà uỷ quyền cho Repo làm việc đó
        return $this->productRepo->getProductsForAdmin($filters);
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ImportProductRequest;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Services\ProductService;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;
    protected $productRepo;

    protected $categoryRepo;

    public function __construct(ProductService $productService, ProductRepositoryInterface $productRepo, CategoryRepositoryInterface $categoryRepo)
    {
        $this->productService = $productService;
        $this->productRepo = $productRepo;
        $this->categoryRepo = $categoryRepo;
    }

    public function index(Request $request)
    {
        $categories = $this->categoryRepo->getAll();

        // Lấy danh sách sản phẩm (có truyền kèm data từ request để lọc)
        $products = $this->productService->getProductsForAdmin($request->all());
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = $this->categoryRepo->getAll();
        return view('admin.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        $this->productService->storeProduct($request->validated(), $request->file('images'));
        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    public function edit($id)
    {
        $product = $this->productRepo->findById($id);
        $categories = $this->categoryRepo->getAll();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, $id)
    {
        try {
            // Chuyển toàn bộ dữ liệu (bao gồm Data chữ và Mảng file ảnh) sang Service xử lý
            $this->productService->updateProduct($id, $request->validated(), $request->file('images'));

            return redirect()->route('admin.products.index')
                ->with('success', 'Cập nhật thông tin và hình ảnh sản phẩm thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Cập nhật thất bại: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $this->productService->deleteProduct($id);
        return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công!');
    }

    public function deleteImage($imageId)
    {
        $this->productService->deleteSingleImage($imageId);
        return back()->with('success', 'Đã xóa ảnh thành công.');
    }

    public function import(ImportProductRequest $request)
    {
        try {
            $count = $this->productService->importFromCsv($request->file('file'));
            return redirect()->route('admin.products.index')
                ->with('success', "Đã nhập thành công {$count} sản phẩm vào kho hàng!");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra trong quá trình import: ' . $e->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        try {
            $product = $this->productService->toggleStatus($id);

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật trạng thái thành công!',
                'is_active' => $product->is_active
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }
}

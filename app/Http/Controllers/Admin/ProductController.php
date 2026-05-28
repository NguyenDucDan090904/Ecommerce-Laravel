<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Services\ProductService;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Models\Category;

class ProductController extends Controller
{
    protected $productService;
    protected $productRepo;

    public function __construct(ProductService $productService, ProductRepositoryInterface $productRepo)
    {
        $this->productService = $productService;
        $this->productRepo = $productRepo;
    }

    public function index()
    {
        $products = $this->productRepo->getAllPaginated(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
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
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $this->productService->updateProduct($id, $request->validated(), $request->file('images'));
        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
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
}

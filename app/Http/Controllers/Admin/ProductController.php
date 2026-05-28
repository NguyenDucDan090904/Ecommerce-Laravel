<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Requests\Admin\StoreProductRequest;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['category', 'images'])->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($request->name) . '-' . time();

        $product = Product::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'path'       => $path
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product = Product::with(['category', 'images'])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        // Eager load ảnh để hiển thị trong trang sửa
        $product->load('images');

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProductRequest $request, Product $product)
    {
        $data = $request->validated();

        if ($product->name !== $request->name) {
            $data['slug'] = Str::slug($request->name) . '-' . time();
        }

        $product->update($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    public function deleteImage(string $id)
    {
        // Tìm trực tiếp bằng ID để tránh lỗi binding mô hình nâng cao
        $image = ProductImage::findOrFail($id);
        $productId = $image->product_id;

        // 1. Thực hiện xóa file vật lý trên đĩa cứng đầu tiên
        if ($image->path && Storage::disk('public')->exists($image->path)) {
            Storage::disk('public')->delete($image->path);
        }

        // 2. Tiến hành xóa bản ghi trong DB
        $image->delete();

        // 3. Điều hướng quay lại kèm thông báo tường minh
        return redirect()->route('admin.products.edit', $productId)
            ->with('success', 'Xóa ảnh thành công! Ảnh tiếp theo đã được đẩy làm ảnh đại diện.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // 1. Duyệt qua danh sách ảnh để xóa file vật lý trong ổ đĩa (tránh rác server)
        if ($product->images && $product->images->isNotEmpty()) {
            foreach ($product->images as $image) {
                if ($image->path && Storage::disk('public')->exists($image->path)) {
                    Storage::disk('public')->delete($image->path);
                }
            }
        }

        // 2. Xóa bản ghi sản phẩm trong Database
        // Lưu ý: Nếu DB của bạn có cài đặt foreign key cascade cho bảng product_images,
        // các bản ghi ảnh sẽ tự động mất. Nếu không, ta xóa thủ công:
        $product->images()->delete();
        $product->delete();

        // 3. Điều hướng trở lại kèm thông báo thành công bừng xanh giao diện
        return redirect()->route('admin.products.index')
            ->with('success', 'Xóa sản phẩm và toàn bộ dữ liệu hình ảnh thành công!');
    }
}

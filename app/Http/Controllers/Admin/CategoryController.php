<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Services\CategoryService;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    protected $categoryService;
    protected $categoryRepo;

    public function __construct(CategoryService $categoryService, CategoryRepositoryInterface $categoryRepo)
    {
        $this->categoryService = $categoryService;
        $this->categoryRepo = $categoryRepo;
    }

    public function index()
    {
        $categories = $this->categoryRepo->getAll();
        return view('admin.categories.index', compact('categories'));
    }

    public function create() { return view('admin.categories.create'); }

    public function store(CategoryRequest $request)
    {
        $this->categoryService->storeCategory($request->validated());
        return redirect()->route('admin.categories.index')->with('success', 'Thêm danh mục thành công!');
    }

    public function edit($id)
    {
        $category = $this->categoryRepo->findById($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, $id)
    {
        $this->categoryService->updateCategory($id, $request->validated());
        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
    {
        $this->categoryService->deleteCategory($id);
        return redirect()->route('admin.categories.index')->with('success', 'Xóa thành công!');
    }
}

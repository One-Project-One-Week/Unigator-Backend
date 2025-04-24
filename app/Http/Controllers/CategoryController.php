<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use App\Traits\HttpResponses;
use Exception;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use HttpResponses;
    protected $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        //
        try {
            $categories = CategoryResource::collection($this->categoryService->getAll()->load('programs'));
            return $this->success('category-success', $categories, 'Categories retrieved successfully.', 200);
        } catch (Exception $e) {
            return $this->fail('category-fail', null, $e->getMessage(), 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        //
        try {
            $validatedData = $request->validated();
            $category = CategoryResource::make($this->categoryService->createData($validatedData));
            return $this->success('category-success', $category, 'Category created successfully.', 201);
        } catch (Exception $e) {
            return $this->fail('category-fail', null, $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        try {
            $category = CategoryResource::make($this->categoryService->getDataById($id));
            return $this->success('category-success', $category, 'Category retrieved successfully.', 200);
        } catch (Exception $e) {
            return $this->fail('category-fail', null, $e->getMessage(), 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        try {
            $category = CategoryResource::make($this->categoryService->getDataById($id));
            return $this->success('category-success', $category, 'Category retrieved successfully.', 200);
        } catch (Exception $e) {
            return $this->fail('category-fail', null, $e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {
        //
        try {
            $validatedData = $request->validated();
            $category = $this->categoryService->updateData($validatedData, $id);
            $resCategory = CategoryResource::make($this->categoryService->getDataById($id));
            return $this->success('category-success', $resCategory, 'Category updated successfully.', 200);
        } catch (Exception $e) {
            return $this->fail('category-fail', null, $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            $resCategory = $this->categoryService->deleteData($id);
            return $this->success('category-success', null, 'Category deleted successfully.', 200);
        } catch (Exception $e) {
            return $this->fail('category-fail', null, $e->getMessage(), 500);
        }
    }
}
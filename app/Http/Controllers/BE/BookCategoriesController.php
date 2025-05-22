<?php

namespace App\Http\Controllers\BE;

use App\Http\Controllers\Controller;
use App\Repositories\BookCategoriesRepository;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Exception;

class BookCategoriesController extends Controller
{
    protected $bookCategoryRepository;


    public function __construct(BookCategoriesRepository $bookCategoryRepository)
    {
        $this->bookCategoryRepository = $bookCategoryRepository;
    }


    public function index()
    {
        try {
            $categories = $this->bookCategoryRepository->getAllBookCategories();
            return ApiResponse::success($categories, 'Fetched all categories successfully');
        } catch (Exception $e) {
            return ApiResponse::error('Failed to fetch categories: ' . $e->getMessage(), 500);
        }
    }


    public function store(Request $request)
    {
        try {

            $data = $request->validate([
                'categories_name' => 'required|string|max:255',
            ]);


            $category = $this->bookCategoryRepository->createBookCategories($data);
            return ApiResponse::success($category, 'Category created successfully', 201);
        } catch (Exception $e) {
            return ApiResponse::error('Failed to create category: ' . $e->getMessage(), 500);
        }
    }


    public function show($id)
    {
        try {
            $category = $this->bookCategoryRepository->getBookCategoriesById($id);
            if (!$category) {
                return ApiResponse::error('Category not found', 404);
            }
            return ApiResponse::success($category, 'Category retrieved successfully');
        } catch (Exception $e) {
            return ApiResponse::error('Failed to retrieve category: ' . $e->getMessage(), 500);
        }
    }


    public function update(Request $request, $id)
    {
        try {

            $data = $request->validate([
               'categories_name' => 'required|string|max:255',
            ]);


            $category = $this->bookCategoryRepository->updateBookCategories($id, $data);
            if (!$category) {
                return ApiResponse::error('Category not found or failed to update', 404);
            }
            return ApiResponse::success($category, 'Category updated successfully');
        } catch (Exception $e) {
            return ApiResponse::error('Failed to update category: ' . $e->getMessage(), 500);
        }
    }


    public function destroy($id)
    {
        try {
            $deleted = $this->bookCategoryRepository->deleteBookCategories($id);
            if (!$deleted) {
                return ApiResponse::error('Category not found or failed to delete', 404);
            }
            return ApiResponse::success(null, 'Category deleted successfully');
        } catch (Exception $e) {
            return ApiResponse::error('Failed to delete category: ' . $e->getMessage(), 500);
        }
    }
}


<?php
namespace App\Repositories;

use App\Models\BookCategories;
use Illuminate\Database\Eloquent\Collection;

class BookCategoriesRepository
{

    public function getAllBookCategories(): Collection
    {
        return BookCategories::all();
    }


    public function createBookCategories(array $data): BookCategories
    {
        return BookCategories::create($data);
    }


    public function getBookCategoriesById(int $id): ?BookCategories
    {
        return BookCategories::find($id);
    }


    public function updateBookCategories(int $id, array $data): ?BookCategories
    {
        $category = BookCategories::find($id);
        if ($category) {
            $category->update($data);
        }
        return $category;
    }


    public function deleteBookCategories(int $id): bool
    {
        $category = BookCategories::find($id);
        if ($category) {
            return $category->delete();
        }
        return false;
    }
}

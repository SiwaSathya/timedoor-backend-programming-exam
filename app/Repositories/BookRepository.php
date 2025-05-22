<?php
namespace App\Repositories;

use App\Models\Book;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class BookRepository
{


    public function getAllBooks(?string $search = null, int $perPage = 10): Paginator
    {
        $query = Book::with('author', 'bookCategories')
                     ->select('books.*')
                     ->leftJoin('rates', 'books.id', '=', 'rates.book_id')
                     ->groupBy('books.id');


        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('book_name', 'LIKE', '%' . $search . '%')
                  ->orWhereHas('author', function($query) use ($search) {
                      $query->where('name', 'LIKE', '%' . $search . '%');
                  });
            });
        }


        $books = $query->addSelect(DB::raw('ROUND(AVG(rates.rating), 0) as avg_rating'))
                       ->addSelect(DB::raw('COUNT(rates.rating) as voter'))
                       ->orderByDesc('avg_rating')
                       ->paginate($perPage);

        return $books;
    }




    public function createBook(array $data): Book
    {
        return Book::create($data);
    }


    public function getBookById(int $id): ?Book
    {
        return Book::with('book_categories', 'author')->find($id);
    }

    public function getBookByAuthorId(int $authorId)
{
    return Book::where('author_id', $authorId)->get();
}


    public function updateBook(int $id, array $data): ?Book
    {
        $book = Book::find($id);
        if ($book) {
            $book->update($data);
        }
        return $book;
    }


    public function deleteBook(int $id): bool
    {
        $book = Book::find($id);
        if ($book) {
            return $book->delete();
        }
        return false;
    }
}

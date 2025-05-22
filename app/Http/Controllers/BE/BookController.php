<?php
namespace App\Http\Controllers\BE;

use App\Http\Controllers\Controller;
use App\Repositories\BookRepository;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Exception;

class BookController extends Controller
{
    protected $bookRepository;


    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function getBooks(Request $request)
    {
        try {

            $search = $request->get('search', null);
            $perPage = $request->get('perPage', 10);


            $books = $this->bookRepository->getAllBooks($search, $perPage);

            return ApiResponse::success($books, 'Fetched all books successfully');
        } catch (Exception $e) {
            return ApiResponse::error('Failed to fetch books: ' . $e->getMessage(), 500);
        }
    }

    public function getBookByAuthorId($id)
    {
        try {
            $book = $this->bookRepository->getBookByAuthorId($id);

            if (!$book) {
                return ApiResponse::error('Book not found', 404);
            }

            return ApiResponse::success($book, 'Book retrieved successfully');
        } catch (Exception $e) {
            return ApiResponse::error('Failed to retrieve book: ' . $e->getMessage(), 500);
        }
    }


    public function index()
    {
        try {
            $books = $this->bookRepository->getAllBooks(10);
            return ApiResponse::success($books, 'Fetched all books successfully');
        } catch (Exception $e) {
            return ApiResponse::error('Failed to fetch books: ' . $e->getMessage(), 500);
        }
    }


    public function store(Request $request)
    {
        try {

            $data = $request->validate([
                'book_name' => 'required|string|max:255',
            ]);


            $book = $this->bookRepository->createBook($data);
            return ApiResponse::success($book, 'Book created successfully', 201);
        } catch (Exception $e) {
            return ApiResponse::error('Failed to create book: ' . $e->getMessage(), 500);
        }
    }


    public function show($id)
    {
        try {
            $book = $this->bookRepository->getBookById($id);

            if (!$book) {
                return ApiResponse::error('Book not found', 404);
            }

            return ApiResponse::success($book, 'Book retrieved successfully');
        } catch (Exception $e) {
            return ApiResponse::error('Failed to retrieve book: ' . $e->getMessage(), 500);
        }
    }


    public function update(Request $request, $id)
    {
        try {

            $data = $request->validate([
                'book_name' => 'required|string|max:255',
            ]);


            $book = $this->bookRepository->updateBook($id, $data);

            if (!$book) {
                return ApiResponse::error('Book not found or failed to update', 404);
            }

            return ApiResponse::success($book, 'Book updated successfully');
        } catch (Exception $e) {
            return ApiResponse::error('Failed to update book: ' . $e->getMessage(), 500);
        }
    }


    public function destroy($id)
    {
        try {
            $deleted = $this->bookRepository->deleteBook($id);

            if (!$deleted) {
                return ApiResponse::error('Book not found or failed to delete', 404);
            }

            return ApiResponse::success(null, 'Book deleted successfully');
        } catch (Exception $e) {
            return ApiResponse::error('Failed to delete book: ' . $e->getMessage(), 500);
        }
    }
}

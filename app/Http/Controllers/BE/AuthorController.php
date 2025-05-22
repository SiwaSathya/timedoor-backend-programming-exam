<?php

namespace App\Http\Controllers\BE;

use App\Http\Controllers\Controller;
use App\Repositories\AuthorRepository;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Exception;

class AuthorController extends Controller
{
    protected $authorRepository;


    public function __construct(AuthorRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }


    public function index()
    {
        try {
            $authors = $this->authorRepository->getTop10AuthorsByVotes();
            return ApiResponse::success($authors, 'Fetched all authors successfully');
        } catch (Exception $e) {
            return ApiResponse::error('Failed to fetch authors: ' . $e->getMessage(), 500);
        }
    }

    public function getAllAuthor()
    {
        try {
            $authors = $this->authorRepository->getAllAuthors();
            return ApiResponse::success($authors, 'Fetched all authors successfully');
        } catch (Exception $e) {
            return ApiResponse::error('Failed to fetch authors: ' . $e->getMessage(), 500);
        }
    }


    public function store(Request $request)
    {
        try {

            $data = $request->validate([
                'name' => 'required|string|max:255',

            ]);


            $author = $this->authorRepository->createAuthor($data);
            return ApiResponse::success($author, 'Author created successfully', 201);
        } catch (Exception $e) {
            return ApiResponse::error('Failed to create author: ' . $e->getMessage(), 500);
        }
    }


    public function show($id)
    {
        try {
            $author = $this->authorRepository->getAuthorById($id);

            if (!$author) {
                return ApiResponse::error('Author not found', 404);
            }

            return ApiResponse::success($author, 'Author retrieved successfully');
        } catch (Exception $e) {
            return ApiResponse::error('Failed to retrieve author: ' . $e->getMessage(), 500);
        }
    }


    public function update(Request $request, $id)
    {
        try {

            $data = $request->validate([
                'name' => 'required|string|max:255',
                'author_id' => 'required',
                'book_id' => 'required',
            ]);


            $author = $this->authorRepository->updateAuthor($id, $data);

            if (!$author) {
                return ApiResponse::error('Author not found or failed to update', 404);
            }

            return ApiResponse::success($author, 'Author updated successfully');
        } catch (Exception $e) {
            return ApiResponse::error('Failed to update author: ' . $e->getMessage(), 500);
        }
    }


    public function destroy($id)
    {
        try {
            $deleted = $this->authorRepository->deleteAuthor($id);

            if (!$deleted) {
                return ApiResponse::error('Author not found or failed to delete', 404);
            }

            return ApiResponse::success(null, 'Author deleted successfully');
        } catch (Exception $e) {
            return ApiResponse::error('Failed to delete author: ' . $e->getMessage(), 500);
        }
    }
}


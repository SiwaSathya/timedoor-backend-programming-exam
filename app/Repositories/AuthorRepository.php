<?php
namespace App\Repositories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Collection;

class AuthorRepository
{

    public function getAllAuthors(): Collection
    {
        return Author::all();
    }

    public function getTop10AuthorsByVotes()
{
    return Author::select('authors.id as id_author', 'authors.name as author_name')
        ->leftJoin('rates', 'authors.id', '=', 'rates.author_id')
        ->selectRaw('COUNT(rates.id) as total_votes')
        ->groupBy('authors.id', 'authors.name')
        ->havingRaw('COUNT(rates.id) > 5')
        ->orderByDesc('total_votes')
        ->limit(10)
        ->get();
}


    public function createAuthor(array $data): Author
    {
        return Author::create($data);
    }


    public function getAuthorById(int $id): ?Author
    {
        return Author::find($id);
    }

    public function getAuthorByName(string $name): ?Author
    {
        return Author::where('name', 'LIKE', '%' . $name . '%')->first();
    }


    public function updateAuthor(int $id, array $data): ?Author
    {
        $author = Author::find($id);
        if ($author) {
            $author->update($data);
        }
        return $author;
    }


    public function deleteAuthor(int $id): bool
    {
        $author = Author::find($id);
        if ($author) {
            return $author->delete();
        }
        return false;
    }
}

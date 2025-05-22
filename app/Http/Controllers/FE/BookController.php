<?php
namespace App\Http\Controllers\FE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter search dan perPage dari query string
        $search = $request->get('search', '');  // Defaultnya kosong jika tidak ada pencarian
        $perPage = $request->get('perPage', 10); // Default perPage 10 jika tidak ada parameter

        // URL untuk API call
        $url = "http://127.0.0.1:8000/api/books-index?search={$search}&perPage={$perPage}";

        // Ambil data dari API
        $response = file_get_contents($url);
        $books = json_decode($response, true);

        // Mengembalikan data ke view
        return view('books.index', compact('books'));
    }
}

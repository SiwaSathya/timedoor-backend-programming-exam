<?php
namespace App\Http\Controllers\FE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function topAuthors()
    {
        // Memanggil API untuk mendapatkan data authors
        $url = "http://127.0.0.1:8000/api/authors";
        $response = file_get_contents($url); // Mengambil data dari API
        $authors = json_decode($response, true); // Mengubah data JSON menjadi array

        // Mengembalikan data ke view
        return view('authors.top', compact('authors'));
    }
}

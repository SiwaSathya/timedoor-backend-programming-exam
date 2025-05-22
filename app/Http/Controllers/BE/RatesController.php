<?php
namespace App\Http\Controllers\BE;

use App\Http\Controllers\Controller;
use App\Repositories\RatesRepository;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Exception;

class RatesController extends Controller
{
    protected $rateRepository;

    // Menyuntikkan RateRepository ke dalam controller
    public function __construct(RatesRepository $rateRepository)
    {
        $this->rateRepository = $rateRepository;
    }

    // Menampilkan semua rate
    public function index()
    {
        try {
            $rates = $this->rateRepository->getAllRates();
            return ApiResponse::success($rates, 'Fetched all rates successfully');
        } catch (Exception $e) {
            return ApiResponse::error('Failed to fetch rates: ' . $e->getMessage(), 500);
        }
    }

    // Menyimpan rate baru
    public function store(Request $request)
    {
        try {
            // Validasi input
            $data = $request->validate([
                'rating' => 'required|numeric',
                'author_id' => 'required',
                'book_id' => 'required',
            ]);

            $rate = $this->rateRepository->createRate($data);
            return ApiResponse::success($rate, 'Rate created successfully', 201);
        } catch (Exception $e) {
            return ApiResponse::error('Failed to create rate: ' . $e->getMessage(), 500);
        }
    }

    // Menampilkan rate berdasarkan ID
    public function show($id)
    {
        try {
            $rate = $this->rateRepository->getRateById($id);

            if (!$rate) {
                return ApiResponse::error('Rate not found', 404);
            }

            return ApiResponse::success($rate, 'Rate retrieved successfully');
        } catch (Exception $e) {
            return ApiResponse::error('Failed to retrieve rate: ' . $e->getMessage(), 500);
        }
    }

    // Memperbarui rate berdasarkan ID
    public function update(Request $request, $id)
    {
        try {
            // Validasi input
            $data = $request->validate([
                'value' => 'required|numeric',
                'description' => 'nullable|string',
            ]);

            // Menggunakan repository untuk memperbarui rate
            $rate = $this->rateRepository->updateRate($id, $data);

            if (!$rate) {
                return ApiResponse::error('Rate not found or failed to update', 404);
            }

            return ApiResponse::success($rate, 'Rate updated successfully');
        } catch (Exception $e) {
            return ApiResponse::error('Failed to update rate: ' . $e->getMessage(), 500);
        }
    }

    // Menghapus rate berdasarkan ID
    public function destroy($id)
    {
        try {
            $deleted = $this->rateRepository->deleteRate($id);

            if (!$deleted) {
                return ApiResponse::error('Rate not found or failed to delete', 404);
            }

            return ApiResponse::success(null, 'Rate deleted successfully');
        } catch (Exception $e) {
            return ApiResponse::error('Failed to delete rate: ' . $e->getMessage(), 500);
        }
    }
}

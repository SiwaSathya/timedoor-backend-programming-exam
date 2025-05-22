<?php
namespace App\Repositories;

use App\Models\Rates;
use Illuminate\Database\Eloquent\Collection;

class RatesRepository
{

    public function getAllRates(): Collection
    {
        return Rates::with('author', 'books')->get();
    }


    public function createRate(array $data): Rates
    {
        return Rates::create($data);
    }


    public function getRateById(int $id): ?Rates
    {
        return Rates::with('author', 'books')->find($id);
    }


    public function updateRate(int $id, array $data): ?Rates
    {
        $rate = Rates::find($id);
        if ($rate) {
            $rate->update($data);
        }
        return $rate;
    }


    public function deleteRate(int $id): bool
    {
        $rate = Rates::find($id);
        if ($rate) {
            return $rate->delete();
        }
        return false;
    }
}

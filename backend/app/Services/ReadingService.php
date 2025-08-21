<?php

namespace App\Services;

use App\Models\Reading;
use Illuminate\Database\Eloquent\Collection;

class ReadingService
{
    public function getAll(): Collection
    {
        return Reading::all();
    }

    public function getById($id): ?Reading
    {
        return Reading::find($id);
    }

    public function create(array $data): Reading
    {
        return Reading::create($data);
    }

    public function update($id, array $data): ?Reading
    {
        $reading = Reading::find($id);
        if (!$reading) {
            return null;
        }
        $reading->update($data);
        return $reading;
    }

    public function delete($id): bool
    {
        $reading = Reading::find($id);
        if (!$reading) {
            return false;
        }
        $reading->delete();
        return true;
    }
}


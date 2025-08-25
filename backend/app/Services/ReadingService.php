<?php

namespace App\Services;

use App\Models\Reading;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class ReadingService
{
    public function getAll($user): Collection
    {
        return $user->readings()->get();
    }

    public function getById(User $user, $id): ?Reading
    {
        return $user->readings()->find($id);
    }

    public function create(User $user, array $data): Reading
    {
        $data['user_id'] = $user->id;
        return Reading::create($data);
    }

    public function update(User $user, $id, array $data): ?Reading
    {
        $reading = $user->readings()->find($id);
        if (!$reading) {
            return null;
        }
        $reading->update($data);
        return $reading;
    }

    public function delete(User $user, $id): bool
    {
        $reading = $user->readings()->find($id);
        if (!$reading) {
            return false;
        }
        $reading->delete();
        return true;
    }
}

<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Schedule as ScheduleModel;
use Illuminate\Support\Collection;

class ScheduleRepository
{
    public function all(): Collection
    {
        return ScheduleModel::orderBy('start_at', 'desc')->get();
    }

    public function create(array $attributes): ScheduleModel
    {
        return ScheduleModel::create($attributes);
    }

    public function delete(int $id): void
    {
        ScheduleModel::destroy($id);
    }
}

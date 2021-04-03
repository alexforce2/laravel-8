<?php declare(strict_types=1);

namespace App\Services;

use App\Models\Schedule as ScheduleModel;
use App\Repositories\ScheduleRepository;
use Illuminate\Support\Collection;

class ScheduleService
{
    private ScheduleRepository $scheduleRepository;

    public function __construct(ScheduleRepository $scheduleRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
    }

    public function getAll(): Collection
    {
        return $this->scheduleRepository->all();
    }

    public function create(array $attributes): ScheduleModel
    {
        return $this->scheduleRepository->create($attributes);
    }

    public function delete(int $id): void
    {
        $this->scheduleRepository->delete($id);
    }
}

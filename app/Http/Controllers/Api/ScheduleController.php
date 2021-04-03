<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Schedule\Create as ScheduleCreateRequest;
use App\Http\Resources\ScheduleResource;
use App\Services\ScheduleService;
use Illuminate\Http\JsonResponse;

class ScheduleController extends Controller
{
    private ScheduleService $scheduleService;

    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    public function index(): JsonResponse
    {
        $schedules = $this->scheduleService->getAll();

        return response()->json(ScheduleResource::collection($schedules));
    }

    public function store(ScheduleCreateRequest $request): JsonResponse
    {
        $schedule = $this->scheduleService->create($request->validationData());

        return response()->json(new ScheduleResource($schedule));
    }

    public function destroy($id): JsonResponse
    {
        $this->scheduleService->delete((int) $id);

        return response()->json('success');
    }
}

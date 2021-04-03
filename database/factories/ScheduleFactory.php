<?php declare(strict_types=1);

namespace Database\Factories;

use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    protected $model = Schedule::class;

    public function definition(): array
    {
        $now = Carbon::now();

        return [
            'title' => $this->faker->text(100),
            'start_at' => $now->format('Y-m-d'),
            'end_at' => $now->addDays(rand(1, 10))->format('Y-m-d'),
        ];
    }
}

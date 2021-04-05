<?php declare(strict_types=1);

namespace App\Rules\Schedule;

use App\Models\Schedule;
use Illuminate\Contracts\Validation\Rule;

class IsDateAvailable implements Rule
{
    private ?string $endAt;

    public function passes($attribute, $startAt): bool
    {
        $busy = Schedule::where(function ($query) use ($startAt) {
            $query->where('start_at', '<=', $startAt)
                ->where('end_at', '>=', $startAt);
        })
            ->orWhere(function ($query) use ($startAt) {
                $query->where('start_at', '>=', $startAt)
                    ->where('start_at', '<=', $this->endAt);
            })
            ->count();

        //в идеале проверку 'end_at' надо вынести в отдельное правило, что бы ошибка отображалась в нужном поле)

        return $busy > 0 ? false : true;
    }

    public function message(): string
    {
        return 'This date ":attribute" has already been booked.';
    }

    public function setEndDate(string $endAt = null): self
    {
        $this->endAt = $endAt;

        return $this;
    }
}

<?php declare(strict_types=1);

namespace App\Rules\Schedule;

use App\Models\Schedule;
use Illuminate\Contracts\Validation\Rule;

class IsDateAvailable implements Rule
{
    public function passes($attribute, $value): bool
    {
        $busy = Schedule::where('start_at', '<=', $value)
           ->orWhere('end_at', '>=', $value)
           ->count();

        return $busy > 0 ? false : true;
    }

    public function message(): string
    {
        return 'This date ":attribute" has already been booked.';
    }
}

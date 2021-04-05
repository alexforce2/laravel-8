<?php declare(strict_types=1);

namespace App\Http\Requests\Schedule;

use App\Rules\Schedule\IsDateAvailable;
use Illuminate\Foundation\Http\FormRequest;

class Create extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isDateAvailable = (new IsDateAvailable())->setEndDate($this->end_at);

        return [
            'title' => ['required', 'string', 'max:255'],
            'start_at' => ['required', 'date_format:Y-m-d', $isDateAvailable],
            'end_at' => ['required', 'date_format:Y-m-d', 'after_or_equal:start_at'],
        ];
    }
}

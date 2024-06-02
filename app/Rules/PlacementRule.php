<?php

namespace App\Rules;

use App\Models\generation;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PlacementRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $generation = generation::query()
            ->where('member_id', request()->placement)
            ->whereNot(request()->position, 'NF23000000')
            ->first();

        if ($generation) {
            $fail('The :attribute is already occupied.');
        }
    }
}
<?php

namespace App\Casts;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class Date implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get($model, string $key, mixed $value, array $attributes)
    {
        return !\is_null($value) ? Carbon::parse($value)->format('d/m/Y') : null;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set($model, string $key, mixed $value, array $attributes)
    {
        return !\is_null($value) ? Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d') : null;
    }
}
